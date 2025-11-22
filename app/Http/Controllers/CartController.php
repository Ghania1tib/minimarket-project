<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        // Langkah 4: Auth::check() untuk proteksi - SESUAI MODUL
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses keranjang');
        }

        // PERBAIKAN: Gunakan user_id bukan pelanggan_id
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum('subtotal');

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $productId)
    {
        Log::info('Add to cart attempt', ['product_id' => $productId, 'user_id' => Auth::id()]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu',
                'redirect' => route('login')
            ], 401);
        }

        try {
            DB::beginTransaction();

            $product = Product::find($productId);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan'
                ], 404);
            }

            Log::info('Product found', ['product' => $product->nama_produk, 'stok' => $product->stok]);

            if ($product->stok < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk habis'
                ], 400);
            }

            // PERBAIKAN: Gunakan user_id dan product_id sesuai database
            $existingCart = Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($existingCart) {
                Log::info('Existing cart item found', ['current_quantity' => $existingCart->quantity]);

                if ($existingCart->quantity + 1 > $product->stok) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stok
                    ], 400);
                }

                // PERBAIKAN: Update quantity bukan jumlah
                $existingCart->update([
                    'quantity' => $existingCart->quantity + 1,
                ]);

                Log::info('Cart item updated', ['new_quantity' => $existingCart->quantity + 1]);
            } else {
                Log::info('Creating new cart item');

                // PERBAIKAN: Gunakan field yang sesuai dengan database
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'quantity' => 1,
                ]);

                Log::info('New cart item created');
            }

            // PERBAIKAN: Gunakan user_id
            $cartCount = Cart::where('user_id', Auth::id())->count();
            $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
            $total = $cartItems->sum('subtotal');

            DB::commit();

            Log::info('Cart updated successfully', ['cart_count' => $cartCount, 'total' => $total]);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'cart_count' => $cartCount,
                'total' => number_format($total, 0, ',', '.'),
                'items_count' => $cartItems->count()
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding to cart', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $cartId)
    {
        if (!Auth::check()) {
            return back()->with('error', 'Silakan login terlebih dahulu');
        }

        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        // PERBAIKAN: Gunakan user_id
        $cart = Cart::where('user_id', Auth::id())
            ->where('id', $cartId)
            ->firstOrFail();

        $product = $cart->product;

        if ($request->jumlah > $product->stok) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stok);
        }

        // PERBAIKAN: Update quantity
        $cart->update([
            'quantity' => $request->jumlah
        ]);

        return back()->with('success', 'Keranjang berhasil diperbarui');
    }

    public function remove($cartId)
    {
        if (!Auth::check()) {
            return back()->with('error', 'Silakan login terlebih dahulu');
        }

        // PERBAIKAN: Gunakan user_id
        $cart = Cart::where('user_id', Auth::id())
            ->where('id', $cartId)
            ->firstOrFail();

        $cart->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    public function count()
    {
        if (Auth::check()) {
            // PERBAIKAN: Gunakan user_id
            $count = Cart::where('user_id', Auth::id())->count();
        } else {
            $count = 0;
        }

        return response()->json(['count' => $count]);
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'kota' => 'required|string',
            'metode_pembayaran' => 'required|in:transfer,cod,ewallet'
        ]);

        // PERBAIKAN: Gunakan user_id
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang belanja kosong');
        }

        // Validasi stok
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stok) {
                return back()->with('error', 'Stok untuk produk "' . $item->product->nama_produk . '" tidak mencukupi. Stok tersedia: ' . $item->product->stok);
            }
        }

        DB::beginTransaction();
        try {
            $total = $cartItems->sum('subtotal');
            $biaya_pengiriman = 15000;
            $total_akhir = $total + $biaya_pengiriman;

            // PERBAIKAN: Create order sesuai struktur database
            $order = Order::create([
                'user_id' => Auth::id(),
                'subtotal' => $total,
                'total_bayar' => $total_akhir,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pesanan' => 'menunggu_pembayaran',
                'tipe_pesanan' => 'online', // atau 'offline'
                // Tambahkan field lain sesuai kebutuhan
            ]);

            // PERBAIKAN: Create order items sesuai struktur database
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'harga_saat_beli' => $item->product->harga_jual,
                    'diskon_item' => 0 // Sesuaikan jika ada diskon
                ]);

                // Update product stock
                $item->product->decrement('stok', $item->quantity);
            }

            // Clear cart - PERBAIKAN: Gunakan user_id
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            // Update user profile
            $user = Auth::user();
            $updateData = [];
            if ($user->nama_lengkap !== $request->nama_lengkap) {
                $updateData['nama_lengkap'] = $request->nama_lengkap;
            }
            if ($user->no_telepon !== $request->no_telepon) {
                $updateData['no_telepon'] = $request->no_telepon;
            }
            if ($user->alamat !== $request->alamat) {
                $updateData['alamat'] = $request->alamat;
            }

            if (!empty($updateData)) {
                $user->update($updateData);
            }

            return redirect()->route('pelanggan.pesanan.detail', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat proses checkout: ' . $e->getMessage());
        }
    }

    public function clear()
    {
        if (!Auth::check()) {
            return back()->with('error', 'Silakan login terlebih dahulu');
        }

        // PERBAIKAN: Gunakan user_id
        Cart::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Keranjang berhasil dikosongkan');
    }

    public function getCartData()
    {
        if (Auth::check()) {
            // PERBAIKAN: Gunakan user_id
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();

            $total = $cartItems->sum('subtotal');
            $count = $cartItems->count();

            return response()->json([
                'success' => true,
                'items' => $cartItems,
                'total' => number_format($total, 0, ',', '.'),
                'count' => $count
            ]);
        }

        return response()->json([
            'success' => false,
            'items' => [],
            'total' => '0',
            'count' => 0
        ]);
    }
}
