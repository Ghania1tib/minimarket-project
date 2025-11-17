<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('pelanggan.pesanan', compact('orders'));
    }

    // PERBAIKAN: Tambahkan method riwayat
    public function riwayat()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
                      ->whereIn('status_pesanan', ['selesai', 'dibatalkan'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('pelanggan.riwayat', compact('orders'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $order = Order::with(['items', 'items.product'])
                     ->where('user_id', $user->id)
                     ->where('id', $id)
                     ->firstOrFail();

        // Timeline status
        $timeline = $this->generateTimeline($order);

        return view('pelanggan.pesanan-detail', compact('order', 'timeline'));
    }

    public function batalkan($id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)
                     ->where('id', $id)
                     ->firstOrFail();

        // Hanya bisa membatalkan pesanan yang masih pending
        if ($order->status_pesanan == 'menunggu_pembayaran') {
            $order->update([
                'status_pesanan' => 'dibatalkan',
                'status_pembayaran' => 'dibatalkan'
            ]);

            // Kembalikan stok produk
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->increment('stok', $item->jumlah);
                }
            }

            return redirect()->route('pelanggan.pesanan.detail', $order->id)
                           ->with('success', 'Pesanan berhasil dibatalkan');
        }

        return redirect()->back()->with('error', 'Tidak dapat membatalkan pesanan ini');
    }

    public function bayar($id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)
                     ->where('id', $id)
                     ->firstOrFail();

        // Simulasi proses pembayaran
        if ($order->status_pesanan == 'menunggu_pembayaran') {
            $order->update([
                'status_pembayaran' => 'lunas',
                'status_pesanan' => 'diproses'
            ]);

            return redirect()->route('pelanggan.pesanan.detail', $order->id)
                           ->with('success', 'Pembayaran berhasil diproses');
        }

        return redirect()->back()->with('error', 'Tidak dapat memproses pembayaran');
    }

    private function generateTimeline($order)
    {
        $timeline = [];

        // Status default untuk semua pesanan
        $timeline[] = [
            'status' => 'Pesanan Dibuat',
            'tanggal' => $order->created_at,
            'icon' => 'fas fa-shopping-cart',
            'active' => true
        ];

        // Berdasarkan status pesanan
        switch ($order->status_pesanan) {
            case 'menunggu_pembayaran':
                $timeline[] = [
                    'status' => 'Menunggu Pembayaran',
                    'tanggal' => $order->created_at->addMinutes(5),
                    'icon' => 'fas fa-clock',
                    'active' => true
                ];
                break;

            case 'diproses':
                $timeline[] = [
                    'status' => 'Pembayaran Diterima',
                    'tanggal' => $order->created_at->addMinutes(10),
                    'icon' => 'fas fa-check-circle',
                    'active' => true
                ];
                $timeline[] = [
                    'status' => 'Sedang Diproses',
                    'tanggal' => $order->created_at->addMinutes(15),
                    'icon' => 'fas fa-cog',
                    'active' => true
                ];
                break;

            case 'dikirim':
                $timeline[] = [
                    'status' => 'Pembayaran Diterima',
                    'tanggal' => $order->created_at->addMinutes(10),
                    'icon' => 'fas fa-check-circle',
                    'active' => true
                ];
                $timeline[] = [
                    'status' => 'Sedang Diproses',
                    'tanggal' => $order->created_at->addMinutes(15),
                    'icon' => 'fas fa-cog',
                    'active' => true
                ];
                $timeline[] = [
                    'status' => 'Dalam Pengiriman',
                    'tanggal' => $order->created_at->addHours(1),
                    'icon' => 'fas fa-truck',
                    'active' => true
                ];
                break;

            case 'selesai':
                $timeline[] = [
                    'status' => 'Pembayaran Diterima',
                    'tanggal' => $order->created_at->addMinutes(10),
                    'icon' => 'fas fa-check-circle',
                    'active' => true
                ];
                $timeline[] = [
                    'status' => 'Sedang Diproses',
                    'tanggal' => $order->created_at->addMinutes(15),
                    'icon' => 'fas fa-cog',
                    'active' => true
                ];
                $timeline[] = [
                    'status' => 'Dalam Pengiriman',
                    'tanggal' => $order->created_at->addHours(1),
                    'icon' => 'fas fa-truck',
                    'active' => true
                ];
                $timeline[] = [
                    'status' => 'Pesanan Selesai',
                    'tanggal' => $order->updated_at,
                    'icon' => 'fas fa-flag-checkered',
                    'active' => true
                ];
                break;

            case 'dibatalkan':
                $timeline[] = [
                    'status' => 'Pesanan Dibatalkan',
                    'tanggal' => $order->updated_at,
                    'icon' => 'fas fa-times-circle',
                    'active' => true
                ];
                break;
        }

        return $timeline;
    }
}
