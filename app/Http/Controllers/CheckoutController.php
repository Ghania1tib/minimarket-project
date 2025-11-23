<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        $total = $cartItems->sum('subtotal');
        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'total', 'user'));
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Debug: Log request data
        Log::info('Checkout Request Data:', $request->all());

        // Validasi yang sesuai dengan ENUM di database
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'metode_pengiriman' => 'required|in:reguler,express',
            'metode_pembayaran' => 'required|in:tunai,debit_kredit,qris_ewallet',
            'catatan' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
            }

            // Hitung total
            $subtotal = $cartItems->sum('subtotal');
            $shippingCost = $request->metode_pengiriman == 'express' ? 25000 : 15000;
            $totalBayar = $subtotal + $shippingCost;

            // Debug: Log sebelum create order
            Log::info('Creating order with data:', [
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'total_bayar' => $totalBayar,
                'metode_pembayaran' => $validatedData['metode_pembayaran'],
                'tipe_pesanan' => 'website',
                'status_pesanan' => 'pending'
            ]);

            // Buat data order
            $orderData = [
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'total_diskon' => 0,
                'total_bayar' => $totalBayar,
                'metode_pembayaran' => $validatedData['metode_pembayaran'],
                'tipe_pesanan' => 'website',
                'status_pesanan' => 'pending',
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'no_telepon' => $validatedData['no_telepon'],
                'alamat' => $validatedData['alamat'],
                'kota' => $validatedData['kota'],
                'metode_pengiriman' => $validatedData['metode_pengiriman'],
                'catatan' => $validatedData['catatan'] ?? null,
            ];

            // Debug: Log order data
            Log::info('Order Data to be created:', $orderData);

            // Buat order
            $order = Order::create($orderData);

            // Buat order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'harga_saat_beli' => $item->product->harga_jual,
                    'diskon_item' => 0,
                ]);
            }

            // Kosongkan cart
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            Log::info('Order created successfully:', ['order_id' => $order->id]);

            return redirect()->route('checkout.success', $order->id)
                             ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
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
}
