<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::with(['items.product'])
                      ->where('user_id', $user->id)
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('pelanggan.pesanan', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product'])
                     ->where('id', $id)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        // Generate timeline berdasarkan status
        $timeline = $this->generateTimeline($order);

        return view('pelanggan.pesanan-detail', compact('order', 'timeline'));
    }

    public function batalkan($id)
    {
        $order = Order::where('id', $id)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        // Hanya bisa membatalkan jika status masih menunggu_pembayaran
        if ($order->status_pesanan != 'menunggu_pembayaran') {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        $order->update([
            'status_pesanan' => 'dibatalkan',
            'status_pembayaran' => 'dibatalkan'
        ]);

        // Kembalikan stok produk
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stok', $item->quantity);
            }
        }

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function bayar($id)
    {
        $order = Order::where('id', $id)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        // Untuk tunai, konfirmasi pembayaran
        if ($order->metode_pembayaran == 'tunai') {
            $order->update([
                'status_pembayaran' => 'lunas',
                'status_pesanan' => 'diproses'
            ]);

            return redirect()->back()->with('success', 'Pembayaran tunai berhasil dikonfirmasi. Pesanan akan segera diproses.');
        }

        return redirect()->back()->with('error', 'Metode pembayaran tidak valid.');
    }

    public function uploadPaymentProof(Request $request, $id)
    {
        // PERBAIKAN: Validasi yang lebih lengkap
        $request->validate([
            'nomor_rekening' => 'required_if:metode_pembayaran,transfer',
            'nama_bank' => 'required_if:metode_pembayaran,transfer',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'nomor_rekening.required_if' => 'Nomor rekening wajib diisi untuk pembayaran transfer.',
            'nama_bank.required_if' => 'Nama bank wajib diisi untuk pembayaran transfer.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload.',
            'bukti_pembayaran.image' => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format file yang diperbolehkan: jpeg, png, jpg, gif.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB.'
        ]);

        $order = Order::where('id', $id)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        // PERBAIKAN: Boleh upload bukti selama status masih menunggu_pembayaran
        if ($order->status_pembayaran != 'menunggu_pembayaran') {
            return redirect()->back()->with('error', 'Pembayaran sudah diproses atau tidak dapat diubah.');
        }

        // Upload bukti pembayaran
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = 'payment_' . time() . '_' . $order->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

            $updateData = [
                'bukti_pembayaran' => $path,
                'status_pembayaran' => 'menunggu_verifikasi' // Status berubah setelah upload bukti
            ];

            // Tambahkan info rekening untuk transfer
            if ($order->metode_pembayaran == 'transfer') {
                $updateData['nomor_rekening'] = $request->nomor_rekening;
                // Simpan nama bank juga jika ada fieldnya, atau tambahkan ke catatan
            }

            $order->update($updateData);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
        }

        return redirect()->back()->with('error', 'Gagal mengupload bukti pembayaran.');
    }

    public function riwayat()
    {
        $user = Auth::user();
        $orders = Order::with(['items.product'])
                      ->where('user_id', $user->id)
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('pelanggan.riwayat', compact('orders'));
    }

    /**
     * Generate timeline berdasarkan status order
     */
    private function generateTimeline($order)
    {
        $timeline = [];

        // Status dasar - pesanan dibuat
        $timeline[] = [
            'status' => 'Pesanan Dibuat',
            'description' => 'Pesanan telah berhasil dibuat',
            'tanggal' => $order->created_at,
            'icon' => 'fas fa-shopping-cart',
            'active' => true
        ];

        // Status berdasarkan status pesanan
        $statusConfig = [
            'menunggu_pembayaran' => [
                'status' => 'Menunggu Pembayaran',
                'description' => 'Menunggu pembayaran dari customer',
                'icon' => 'fas fa-clock'
            ],
            'menunggu_verifikasi' => [
                'status' => 'Menunggu Verifikasi',
                'description' => 'Menunggu verifikasi pembayaran oleh admin',
                'icon' => 'fas fa-hourglass-half'
            ],
            'diproses' => [
                'status' => 'Pesanan Diproses',
                'description' => 'Pesanan sedang diproses oleh penjual',
                'icon' => 'fas fa-cogs'
            ],
            'dikirim' => [
                'status' => 'Pesanan Dikirim',
                'description' => 'Pesanan sedang dalam pengiriman',
                'icon' => 'fas fa-shipping-fast'
            ],
            'selesai' => [
                'status' => 'Pesanan Selesai',
                'description' => 'Pesanan telah sampai dan selesai',
                'icon' => 'fas fa-check-circle'
            ],
            'dibatalkan' => [
                'status' => 'Pesanan Dibatalkan',
                'description' => 'Pesanan telah dibatalkan',
                'icon' => 'fas fa-times-circle'
            ]
        ];

        $currentStatus = $order->status_pesanan;
        $foundCurrent = false;

        foreach ($statusConfig as $status => $config) {
            $isActive = !$foundCurrent && ($status == $currentStatus);
            if ($status == $currentStatus) {
                $foundCurrent = true;
            }

            $timeline[] = [
                'status' => $config['status'],
                'description' => $config['description'],
                'tanggal' => $this->getStatusTime($order, $status),
                'icon' => $config['icon'],
                'active' => $isActive
            ];
        }

        return $timeline;
    }

    private function getStatusTime($order, $status)
    {
        // Logic untuk menentukan waktu status
        switch ($status) {
            case 'menunggu_pembayaran':
                return $order->created_at;
            case 'menunggu_verifikasi':
                return $order->bukti_pembayaran ? $order->updated_at : $order->created_at;
            case 'diproses':
                return $order->created_at;
            case 'dikirim':
                return $order->created_at;
            case 'selesai':
                return $order->created_at;
            case 'dibatalkan':
                return $order->updated_at;
            default:
                return $order->created_at;
        }
    }
}
