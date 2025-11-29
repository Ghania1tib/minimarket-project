<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaymentVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * CEK AKSES UNTUK ADMIN & KASIR
     */
    private function checkAdminKasirAccess()
    {
        $user = Auth::user();
        if (!$user || (!$user->isAdmin() && !$user->isKasir() && !$user->isOwner())) {
            abort(403, 'Unauthorized access.');
        }
        return $user;
    }

    private function getUserRoleInfo()
    {
        $user = Auth::user();
        return [
            'user' => $user,
            'isKasir' => $user->isKasir() && !$user->isAdmin(),
            'isAdmin' => $user->isAdmin() || $user->isOwner()
        ];
    }

    /**
     * DASHBOARD VERIFIKASI & PESANAN
     */
    public function dashboard()
    {
        $roleInfo = $this->getUserRoleInfo();
        $stats = $this->getDashboardStats($roleInfo['isKasir']);

        return view('admin.payment-verification.dashboard', compact('stats', 'roleInfo'));
    }

    /**
     * MANAJEMEN PESANAN - INDEX
     */
    public function ordersIndex(Request $request)
    {
        $roleInfo = $this->getUserRoleInfo();
        $user = $roleInfo['user'];
        $isKasir = $roleInfo['isKasir'];

        $status = $request->get('status', 'all');
        $tipe = $request->get('tipe', $isKasir ? 'pos' : 'all');
        $search = $request->get('search');

        $query = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc');

        // Filter untuk kasir - sekarang bisa akses semua pesanan
        if ($isKasir) {
            $query->where(function($q) {
                $q->where('tipe_pesanan', 'pos')
                  ->orWhere('tipe_pesanan', 'website');
            });
        }

        // Filter status
        if ($status != 'all') {
            $query->where('status_pesanan', $status);
        }

        // Filter tipe
        if ($tipe != 'all') {
            $query->where('tipe_pesanan', $tipe);
        }

        // Filter pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('no_telepon', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(20);
        $totalOrders = $query->count();

        $statusOptions = $this->getStatusOptions();
        $tipeOptions = $this->getTipeOptions($isKasir);

        return view('admin.payment-verification.orders-index', compact(
            'orders', 'status', 'tipe', 'search', 'totalOrders',
            'statusOptions', 'tipeOptions', 'roleInfo'
        ));
    }

    /**
     * DETAIL PESANAN
     */
    public function ordersShow($id)
    {
        $roleInfo = $this->getUserRoleInfo();

        $order = Order::with(['user', 'orderItems.product', 'member'])
            ->findOrFail($id);

        // Kasir sekarang bisa akses semua pesanan
        $statusHistory = $this->getStatusHistory($order);

        return view('admin.payment-verification.orders-show', compact('order', 'statusHistory', 'roleInfo'));
    }

    /**
     * UPDATE STATUS PESANAN
     */
    public function ordersUpdateStatus(Request $request, $id)
    {
        $roleInfo = $this->getUserRoleInfo();

        $request->validate([
            'status_pesanan' => 'required|in:pending,menunggu_pembayaran,menunggu_verifikasi,diproses,dikirim,selesai,dibatalkan',
            'catatan_status' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $order = Order::findOrFail($id);

            // Kasir bisa update status semua pesanan
            $oldStatus = $order->status_pesanan;
            $newStatus = $request->status_pesanan;

            $order->update([
                'status_pesanan' => $newStatus,
                'catatan' => $request->catatan_status ?: $order->catatan
            ]);

            Log::info('Status pesanan diubah', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_by' => $roleInfo['user']->nama_lengkap,
                'role' => $roleInfo['user']->role
            ]);

            DB::commit();

            return redirect()->route('payment.verification.orders.show', $order->id)
                ->with('success', 'Status pesanan berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating order status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengupdate status pesanan: ' . $e->getMessage());
        }
    }

    /**
     * UPDATE PENGIRIMAN
     */
    public function ordersUpdateShipping(Request $request, $id)
    {
        $roleInfo = $this->getUserRoleInfo();

        $request->validate([
            'metode_pengiriman' => 'required|in:reguler,express,ambil_ditempat',
            'catatan_pengiriman' => 'nullable|string|max:500'
        ]);

        try {
            $order = Order::findOrFail($id);

            // Kasir bisa update pengiriman semua pesanan
            $order->update([
                'metode_pengiriman' => $request->metode_pengiriman,
                'catatan' => $request->catatan_pengiriman ?: $order->catatan
            ]);

            Log::info('Info pengiriman diupdate', [
                'order_id' => $order->id,
                'metode_pengiriman' => $request->metode_pengiriman,
                'updated_by' => $roleInfo['user']->nama_lengkap,
                'role' => $roleInfo['user']->role
            ]);

            return redirect()->route('payment.verification.orders.show', $order->id)
                ->with('success', 'Informasi pengiriman berhasil diupdate!');

        } catch (\Exception $e) {
            Log::error('Error updating shipping info: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengupdate informasi pengiriman: ' . $e->getMessage());
        }
    }

    /**
     * VERIFIKASI PEMBAYARAN - INDEX (DAFTAR PESANAN UNTUK VERIFIKASI)
     */
    public function paymentVerificationIndex(Request $request)
    {
        $this->checkAdminKasirAccess();
        $roleInfo = $this->getUserRoleInfo();

        $status = $request->get('status', 'menunggu_verifikasi');

        $query = Order::with(['user', 'orderItems.product'])
            ->where('tipe_pesanan', 'website')
            ->orderBy('created_at', 'desc');

        if ($status == 'menunggu_verifikasi') {
            $query->where('status_pembayaran', 'menunggu_verifikasi');
        } elseif ($status == 'semua') {
            $query->whereIn('status_pembayaran', ['menunggu_verifikasi', 'terverifikasi', 'ditolak']);
        }

        $orders = $query->paginate(20);

        return view('admin.payment-verification.payment-verification', compact('orders', 'status', 'roleInfo'));
    }

    /**
     * DETAIL VERIFIKASI PEMBAYARAN (SINGLE ORDER)
     */
    public function paymentVerificationShow($id)
    {
        $this->checkAdminKasirAccess();
        $roleInfo = $this->getUserRoleInfo();

        $order = Order::with(['user', 'orderItems.product'])
            ->where('tipe_pesanan', 'website')
            ->findOrFail($id);

        return view('admin.payment-verification.payment-show', compact('order', 'roleInfo'));
    }

    /**
     * PROSES VERIFIKASI PEMBAYARAN
     */
    public function paymentVerify(Request $request, $id)
    {
        $roleInfo = $this->getUserRoleInfo();

        $request->validate([
            'catatan' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $order = Order::findOrFail($id);

            $order->update([
                'status_pembayaran' => 'terverifikasi',
                'status_pesanan' => 'diproses',
                'catatan_verifikasi' => $request->catatan
            ]);

            Log::info('Pembayaran diverifikasi', [
                'order_id' => $order->id,
                'verified_by' => $roleInfo['user']->nama_lengkap,
                'role' => $roleInfo['user']->role
            ]);

            DB::commit();

            return redirect()->route('payment.verification.index')
                ->with('success', 'Pembayaran berhasil diverifikasi! Pesanan sekarang diproses.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memverifikasi pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * TOLAK PEMBAYARAN
     */
    public function paymentReject(Request $request, $id)
    {
        $roleInfo = $this->getUserRoleInfo();

        $request->validate([
            'alasan_penolakan' => 'required|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $order = Order::findOrFail($id);

            $order->update([
                'status_pembayaran' => 'ditolak',
                'status_pesanan' => 'dibatalkan',
                'catatan_verifikasi' => $request->alasan_penolakan
            ]);

            // Kembalikan stok produk
            foreach ($order->orderItems as $item) {
                $item->product->increment('stok', $item->quantity);
            }

            Log::info('Pembayaran ditolak', [
                'order_id' => $order->id,
                'rejected_by' => $roleInfo['user']->nama_lengkap,
                'role' => $roleInfo['user']->role
            ]);

            DB::commit();

            return redirect()->route('payment.verification.index')
                ->with('success', 'Pembayaran ditolak dan stok telah dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menolak pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * METHOD HELPER
     */
    private function getDashboardStats($isKasir = false)
    {
        $stats = [
            'menunggu_verifikasi' => Order::where('status_pembayaran', 'menunggu_verifikasi')
                ->where('tipe_pesanan', 'website')
                ->count(),
            'total_pesanan_hari_ini' => Order::whereDate('created_at', Carbon::today())->count(),
            'pesanan_diproses' => Order::where('status_pesanan', 'diproses')->count(),
            'pesanan_dikirim' => Order::where('status_pesanan', 'dikirim')->count(),
        ];

        if (!$isKasir) {
            $stats['total_pendapatan_bulanan'] = Order::where('status_pembayaran', 'terverifikasi')
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('total_bayar');
        }

        return $stats;
    }

    private function getStatusHistory($order)
    {
        $history = [];

        $history[] = [
            'status' => 'Pesanan Dibuat',
            'tanggal' => $order->created_at,
            'icon' => 'fas fa-shopping-cart',
            'active' => true
        ];

        $statusConfig = [
            'pending' => ['icon' => 'fas fa-clock', 'label' => 'Pending'],
            'menunggu_pembayaran' => ['icon' => 'fas fa-money-bill-wave', 'label' => 'Menunggu Pembayaran'],
            'menunggu_verifikasi' => ['icon' => 'fas fa-hourglass-half', 'label' => 'Menunggu Verifikasi'],
            'diproses' => ['icon' => 'fas fa-cogs', 'label' => 'Diproses'],
            'dikirim' => ['icon' => 'fas fa-shipping-fast', 'label' => 'Dikirim'],
            'selesai' => ['icon' => 'fas fa-check-circle', 'label' => 'Selesai'],
            'dibatalkan' => ['icon' => 'fas fa-times-circle', 'label' => 'Dibatalkan']
        ];

        $currentStatus = $order->status_pesanan;
        $foundCurrent = false;

        foreach ($statusConfig as $status => $config) {
            $isActive = !$foundCurrent && ($status == $currentStatus);
            if ($status == $currentStatus) {
                $foundCurrent = true;
            }

            $history[] = [
                'status' => $config['label'],
                'tanggal' => $this->estimateStatusTime($order, $status),
                'icon' => $config['icon'],
                'active' => $isActive
            ];
        }

        return $history;
    }

    private function estimateStatusTime($order, $status)
    {
        switch ($status) {
            case 'pending': return $order->created_at;
            case 'menunggu_pembayaran': return $order->created_at->addMinutes(5);
            case 'menunggu_verifikasi': return $order->created_at->addMinutes(15);
            case 'diproses': return $order->created_at->addMinutes(30);
            case 'dikirim': return $order->created_at->addHours(2);
            case 'selesai': return $order->created_at->addDays(1);
            case 'dibatalkan': return $order->updated_at;
            default: return $order->created_at;
        }
    }

    private function getStatusOptions()
    {
        return [
            'all' => 'Semua Status',
            'pending' => 'Pending',
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Diproses',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];
    }

    private function getTipeOptions($isKasir = false)
    {
        $options = [
            'website' => 'Online',
            'pos' => 'POS/Offline'
        ];

        if ($isKasir) {
            unset($options['all']);
        }

        return $options;
    }
}
