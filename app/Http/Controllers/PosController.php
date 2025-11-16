<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    // Tampilkan halaman POS
    public function newTransaction()
    {
        $products = Product::with('category')
                          ->where('stok', '>', 0)
                          ->orderBy('nama_produk')
                          ->get();

        $members = Member::orderBy('nama_lengkap')->get();

        return view('pos.new', compact('products', 'members'));
    }

    // Proses transaksi
    public function processTransaction(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'member_id' => 'nullable|exists:members,id',
            'metode_pembayaran' => 'required|in:tunai,debit_kredit,qris_ewallet',
            'total_bayar' => 'required|numeric|min:0',
            'uang_dibayar' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $items = $request->items;
            $memberId = $request->member_id;
            $metodePembayaran = $request->metode_pembayaran;
            $uangDibayar = $request->uang_dibayar;

            // Hitung total transaksi
            $subtotal = 0;
            $totalDiskon = 0;

            foreach ($items as $item) {
                $product = Product::find($item['product_id']);
                $harga = $product->harga_jual;
                $quantity = $item['quantity'];

                $subtotal += $harga * $quantity;

                // Cek stok
                if ($product->stok < $quantity) {
                    throw new \Exception("Stok {$product->nama_produk} tidak mencukupi. Stok tersedia: {$product->stok}");
                }
            }

            $totalBayar = $subtotal - $totalDiskon;

            // Validasi uang dibayar
            if ($uangDibayar < $totalBayar) {
                throw new \Exception("Uang yang dibayar kurang dari total yang harus dibayar.");
            }

            // Buat order
            $order = Order::create([
                'user_id' => $user->id,
                'member_id' => $memberId,
                'subtotal' => $subtotal,
                'total_diskon' => $totalDiskon,
                'total_bayar' => $totalBayar,
                'metode_pembayaran' => $metodePembayaran,
                'tipe_pesanan' => 'pos',
                'status_pesanan' => 'selesai'
            ]);

            // Buat order items dan update stok
            foreach ($items as $item) {
                $product = Product::find($item['product_id']);
                $harga = $product->harga_jual;
                $quantity = $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'harga_saat_beli' => $harga,
                    'diskon_item' => 0
                ]);

                // Update stok produk
                $product->decrement('stok', $quantity);
            }

            // Hitung kembalian
            $kembalian = $uangDibayar - $totalBayar;

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diproses!',
                'order_id' => $order->id,
                'total_bayar' => $totalBayar,
                'uang_dibayar' => $uangDibayar,
                'kembalian' => $kembalian,
                'invoice_url' => route('pos.invoice', $order->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    // Get product details untuk AJAX
    public function getProduct($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $product->id,
            'nama_produk' => $product->nama_produk,
            'harga_jual' => $product->harga_jual,
            'stok' => $product->stok,
            'kategori' => $product->category->nama_kategori,
            'harga_formatted' => 'Rp ' . number_format($product->harga_jual, 0, ',', '.')
        ]);
    }

    // Tampilkan invoice
    public function showInvoice($id)
    {
        $order = Order::with(['orderItems.product', 'user', 'member'])->findOrFail($id);
        return view('pos.invoice', compact('order'));
    }

    // Method lain yang sudah ada
    public function checkInventory()
    {
        return view('inventory_check');
    }

    public function manageDiscounts()
    {
        return view('discount_management');
    }

    public function cashierReport()
    {
        return view('cashier_report');
    }
}
