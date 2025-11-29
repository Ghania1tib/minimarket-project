<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Kategori;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        // TAMBAH: Data untuk dashboard staff
        $dashboardData = $this->getStaffDashboardData();

        return view('staff_dashboard', $dashboardData);
    }

    /**
     * Mendapatkan data untuk dashboard staff
     */
    private function getStaffDashboardData()
    {
        // Data statistik
        $pendingVerification = Order::where('status_pembayaran', 'menunggu_verifikasi')
            ->where('tipe_pesanan', 'website')
            ->count();

        $productCount = Product::count();

        $lowStockCount = Product::whereColumn('stok', '<=', 'stok_kritis')->count();

        $categoryCount = Kategori::count();

        // TAMBAH: Data aktivitas terbaru
        $recentActivities = Order::with(['user' => function($query) {
                $query->select('id', 'nama_lengkap');
            }])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($order) {
                $paymentMethod = $this->getPaymentMethodText($order->metode_pembayaran ?? 'cash');

                return [
                    'title' => 'Pesanan #' . $order->order_number,
                    'description' => 'Rp ' . number_format($order->total_bayar, 0, ',', '.') . ' - ' . $paymentMethod,
                    'user' => $order->user->nama_lengkap ?? 'Customer',
                    'time' => $order->created_at,
                    'color' => $this->getStatusColor($order->status_pembayaran),
                    'icon' => 'fas fa-shopping-cart'
                ];
            });

        // Data stok menipis
        $lowStockProducts = Product::whereColumn('stok', '<=', 'stok_kritis')
            ->orderBy('stok', 'asc')
            ->take(5)
            ->get();

        return [
            'pendingVerification' => $pendingVerification,
            'productCount' => $productCount,
            'lowStockCount' => $lowStockCount,
            'categoryCount' => $categoryCount,
            'recentActivities' => $recentActivities,
            'lowStockProducts' => $lowStockProducts
        ];
    }

    /**
     * Mendapatkan warna berdasarkan status pembayaran
     */
    private function getStatusColor($status)
    {
        $colors = [
            'menunggu_verifikasi' => 'warning',
            'terverifikasi' => 'success',
            'ditolak' => 'danger',
            'pending' => 'secondary'
        ];

        return $colors[$status] ?? 'primary';
    }

    /**
     * Mendapatkan teks metode pembayaran
     */
    private function getPaymentMethodText($method)
    {
        $methods = [
            'cash' => 'Tunai',
            'qris' => 'QRIS',
            'debit' => 'Debit',
            'credit' => 'Kredit',
            'transfer' => 'Transfer'
        ];

        return $methods[$method] ?? 'Tunai';
    }

    public function pos()
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        return view('staff.pos');
    }
}
