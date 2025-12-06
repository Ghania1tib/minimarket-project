<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        // Validasi stok untuk setiap item
        foreach ($cartItems as $item) {
            if ($item->product->stok < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok {$item->product->nama_produk} tidak mencukupi. Stok tersedia: {$item->product->stok}");
            }
        }

        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->harga_jual;
        });

        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'total', 'user'));
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        Log::info('Checkout Request Data:', $request->all());

        try {
            // Validasi data dasar
            $validatedData = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'no_telepon' => 'required|string|max:15',
                'alamat' => 'required|string',
                'kota' => 'required|string|max:100',
                'metode_pengiriman' => 'required|in:reguler,express',
                'metode_pembayaran' => 'required|in:tunai,transfer,qris',
                'catatan' => 'nullable|string',
            ]);

            // Validasi conditional untuk bukti pembayaran
            // if (in_array($request->metode_pembayaran, ['transfer', 'qris'])) {
            //     $request->validate([
            //         'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            //     ]);
            // }

            DB::beginTransaction();

            $user = Auth::user();
            $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
            }

            // Validasi stok sebelum proses
            foreach ($cartItems as $item) {
                if ($item->product->stok < $item->quantity) {
                    throw new \Exception("Stok {$item->product->nama_produk} tidak mencukupi. Stok tersedia: {$item->product->stok}");
                }
            }

            // Hitung subtotal dengan benar
            $subtotal = $cartItems->sum(function($item) {
                return $item->quantity * $item->product->harga_jual;
            });

            $shippingCost = $this->calculateShippingCost($request->alamat, $request->kota, $request->metode_pengiriman);
            $totalBayar = $subtotal + $shippingCost;

            // Generate order number
            $orderNumber = 'TS-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            // Handle upload bukti pembayaran
            $buktiPembayaranPath = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

                // Log untuk debugging
                Log::info('Bukti pembayaran disimpan di: ' . $buktiPembayaranPath);
            }

            // Tentukan status berdasarkan metode pembayaran
            if ($validatedData['metode_pembayaran'] == 'tunai') {
                $statusPembayaran = Order::STATUS_PEMBAYARAN_MENUNGGU;
                $statusPesanan = Order::STATUS_PESANAN_MENUNGGU;
            } else {
                $statusPembayaran = Order::STATUS_PEMBAYARAN_MENUNGGU;
                $statusPesanan = Order::STATUS_PESANAN_MENUNGGU;
            }

            // Data order - sesuaikan dengan struktur database
            $orderData = [
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'subtotal' => $subtotal,
                'total_diskon' => 0,
                'shipping_cost' => $shippingCost,
                'total_bayar' => $totalBayar,
                'metode_pembayaran' => $validatedData['metode_pembayaran'],
                'bukti_pembayaran' => $buktiPembayaranPath,
                'status_pembayaran' => $statusPembayaran,
                'status_pesanan' => $statusPesanan,
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'no_telepon' => $validatedData['no_telepon'],
                'alamat' => $validatedData['alamat'],
                'kota' => $validatedData['kota'],
                'metode_pengiriman' => $validatedData['metode_pengiriman'],
                'catatan' => $validatedData['catatan'] ?? null,
                'tipe_pesanan' => 'website'
            ];

            Log::info('Order Data to be created:', $orderData);

            // Buat order
            $order = Order::create($orderData);

            // Buat order items dan update stok
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'harga_saat_beli' => $item->product->harga_jual,
                    'diskon_item' => 0,
                ]);

                // Update stok produk dengan validasi
                $product = $item->product;
                if ($product->stok < $item->quantity) {
                    throw new \Exception("Stok {$product->nama_produk} habis selama proses checkout");
                }

                $product->decrement('stok', $item->quantity);

                // Log update stok
                Log::info("Stok produk {$product->nama_produk} dikurangi {$item->quantity}. Stok sekarang: {$product->stok}");
            }

            // Kosongkan cart
            $cartDeleted = Cart::where('user_id', $user->id)->delete();
            Log::info('Cart items deleted: ' . $cartDeleted);

            // Update profil user jika ada perubahan
            $this->updateUserProfile($user, $validatedData);

            DB::commit();

            Log::info('Order created successfully:', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'total' => $order->total_bayar
            ]);

            // Redirect berdasarkan metode pembayaran
            if ($validatedData['metode_pembayaran'] == 'tunai') {
                $message = 'Pesanan berhasil dibuat! Silakan siapkan pembayaran tunai saat barang diterima.';
            } else {
                $message = 'Pesanan berhasil dibuat! Pembayaran Anda sedang menunggu verifikasi admin.';
            }

            return redirect()->route('pelanggan.pesanan.detail', $order->id)
                             ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // Hapus bukti pembayaran jika sudah diupload tetapi terjadi error
            if (isset($buktiPembayaranPath) && Storage::disk('public')->exists($buktiPembayaranPath)) {
                Storage::disk('public')->delete($buktiPembayaranPath);
            }

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function processPaymentUpload(Request $request, $orderId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $order = Order::where('id', $orderId)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

            if ($order->status_pembayaran !== Order::STATUS_PEMBAYARAN_MENUNGGU) {
                return back()->with('error', 'Pembayaran tidak dapat diupload untuk status order ini.');
            }

            // Hapus bukti lama jika ada
            if ($order->bukti_pembayaran && Storage::disk('public')->exists($order->bukti_pembayaran)) {
                Storage::disk('public')->delete($order->bukti_pembayaran);
            }

            // Upload bukti baru
            $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

            $order->update([
                'bukti_pembayaran' => $buktiPembayaranPath,
                'status_pembayaran' => Order::STATUS_PEMBAYARAN_VERIFIKASI,
                'status_pesanan' => Order::STATUS_PESANAN_VERIFIKASI,
            ]);

            return redirect()->route('pelanggan.pesanan.detail', $order->id)
                             ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');

        } catch (\Exception $e) {
            Log::error('Payment upload error: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengupload bukti pembayaran: ' . $e->getMessage());
        }
    }

    private function calculateShippingCost($alamat, $kota, $metodePengiriman)
    {
        // Cek apakah alamat atau kota mengandung kata "Rumbai" (case insensitive)
        $isRumbaiArea = stripos($alamat, 'rumbai') !== false || stripos($kota, 'rumbai') !== false;

        if ($isRumbaiArea) {
            Log::info('Gratis ongkir untuk wilayah Rumbai');
            return 0; // Gratis ongkir untuk wilayah Rumbai
        }

        // Ongkir untuk luar Rumbai
        $cost = $metodePengiriman == 'express' ? 25000 : 15000;
        Log::info("Ongkir calculated: {$cost} untuk {$metodePengiriman}");

        return $cost;
    }

    private function updateUserProfile($user, $data)
    {
        $updateData = [];

        // Handle perbedaan nama field antara user dan order
        $userName = $user->nama_lengkap ?? $user->name;
        $userPhone = $user->no_telepon ?? $user->phone;
        $userAddress = $user->alamat ?? $user->address;

        if ($userName !== $data['nama_lengkap']) {
            $updateData['nama_lengkap'] = $data['nama_lengkap'];
        }
        if ($userPhone !== $data['no_telepon']) {
            $updateData['no_telepon'] = $data['no_telepon'];
        }
        if ($userAddress !== $data['alamat']) {
            $updateData['alamat'] = $data['alamat'];
        }

        if (!empty($updateData)) {
            $user->update($updateData);
            Log::info('User profile updated during checkout:', $updateData);
        }
    }

    public function success($orderId)
    {
        $order = Order::with(['items.product', 'user'])
                     ->where('id', $orderId)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        return view('checkout.success', compact('order'));
    }

    /**
     * Method untuk mendapatkan statistik verifikasi (digunakan di dashboard)
     */
    public static function getVerificationStats()
    {
        return [
            'menunggu_verifikasi' => Order::where('status_pembayaran', Order::STATUS_PEMBAYARAN_VERIFIKASI)
                ->where('tipe_pesanan', 'website')
                ->count(),
            'terverifikasi_hari_ini' => Order::where('status_pembayaran', Order::STATUS_PEMBAYARAN_TERVERIFIKASI)
                ->where('tipe_pesanan', 'website')
                ->whereDate('updated_at', today())
                ->count(),
            'total_pesanan_online' => Order::where('tipe_pesanan', 'website')->count(),
            'pesanan_ditolak' => Order::where('status_pembayaran', Order::STATUS_PEMBAYARAN_DITOLAK)
                ->where('tipe_pesanan', 'website')
                ->count(),
        ];
    }
}
