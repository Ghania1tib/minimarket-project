<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Tampilkan halaman POS
    public function newTransaction()
    {
        if (! Auth::check() || (! Auth::user()->isKasir() && ! Auth::user()->isOwner() && ! Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $products = Product::with('kategori')
            ->where('stok', '>', 0)
            ->orderBy('nama_produk')
            ->get();

        // Ambil kategori unik dari produk yang tersedia
        $categories = Kategori::whereHas('products', function ($query) {
            $query->where('stok', '>', 0);
        })->get();

        return view('pos.new', compact('products', 'categories'));
    }

    // TAMBAHKAN: Method untuk pencarian member berdasarkan nomor telepon
    public function searchMemberByPhone(Request $request)
    {
        if (! Auth::check() || (! Auth::user()->isKasir() && ! Auth::user()->isOwner() && ! Auth::user()->isAdmin())) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        $phone = $request->get('phone');

        if (! $phone) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor telepon member tidak boleh kosong',
            ], 400);
        }

        // Bersihkan format telepon
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

        $member = Member::where('nomor_telepon', $cleanPhone)
            ->orWhere('nomor_telepon', 'like', '%' . $cleanPhone . '%')
            ->first();

        if ($member) {
            return response()->json([
                'success' => true,
                'member'  => [
                    'id'            => $member->id,
                    'kode_member'   => $member->kode_member,
                    'nama_lengkap'  => $member->nama_lengkap,
                    'nomor_telepon' => $member->nomor_telepon,
                    'poin'          => $member->poin,
                    'diskon'        => $member->diskon ?? 10,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Member dengan nomor telepon tersebut tidak ditemukan',
        ], 404);
    }

    // Method untuk pencarian member berdasarkan kode
    public function searchMemberByKode(Request $request)
    {
        if (! Auth::check() || (! Auth::user()->isKasir() && ! Auth::user()->isOwner() && ! Auth::user()->isAdmin())) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        $kode = $request->get('kode');

        if (! $kode) {
            return response()->json([
                'success' => false,
                'message' => 'Kode member tidak boleh kosong',
            ], 400);
        }

        $member = Member::where('kode_member', $kode)->first();

        if ($member) {
            return response()->json([
                'success' => true,
                'member'  => [
                    'id'            => $member->id,
                    'kode_member'   => $member->kode_member,
                    'nama_lengkap'  => $member->nama_lengkap,
                    'nomor_telepon' => $member->nomor_telepon,
                    'poin'          => $member->poin,
                    'diskon'        => $member->diskon ?? 10,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Member tidak ditemukan',
        ], 404);
    }

    // Proses transaksi dengan diskon member
    public function processTransaction(Request $request)
    {
        if (! Auth::check() || (! Auth::user()->isKasir() && ! Auth::user()->isOwner() && ! Auth::user()->isAdmin())) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }

        $request->validate([
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'member_id'          => 'nullable|exists:members,id',
            'metode_pembayaran'  => 'required|in:tunai,debit_kredit,qris_ewallet',
            'uang_dibayar'       => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $user             = Auth::user();
            $items            = $request->items;
            $memberId         = $request->member_id;
            $metodePembayaran = $request->metode_pembayaran;
            $uangDibayar      = $request->uang_dibayar;

            // Hitung total transaksi
            $subtotal    = 0;
            $totalDiskon = 0;

            foreach ($items as $item) {
                $product  = Product::find($item['product_id']);
                $harga    = $product->harga_jual;
                $quantity = $item['quantity'];

                $subtotal += $harga * $quantity;

                // Cek stok
                if ($product->stok < $quantity) {
                    throw new \Exception("Stok {$product->nama_produk} tidak mencukupi. Stok tersedia: {$product->stok}");
                }
            }

            // Hitung diskon member 10%
            $poinBertambah = 0;
            if ($memberId) {
                $member = Member::find($memberId);
                if ($member) {
                    $totalDiskon = $subtotal * (($member->diskon ?? 10) / 100);

                    // Hitung poin yang didapat (1 poin per Rp 10.000)
                    $poinBertambah = floor($subtotal / 10000);
                }
            }

            $totalBayar = $subtotal - $totalDiskon;

            // Validasi uang dibayar
            if ($uangDibayar < $totalBayar) {
                throw new \Exception("Uang yang dibayar kurang dari total yang harus dibayar.");
            }

            // Buat order
            $order = Order::create([
                'user_id'           => $user->id,
                'member_id'         => $memberId,
                'subtotal'          => $subtotal,
                'total_diskon'      => $totalDiskon,
                'total_bayar'       => $totalBayar,
                'metode_pembayaran' => $metodePembayaran,
                'tipe_pesanan'      => 'pos',
                'status_pesanan'    => 'selesai',
            ]);

            // Buat order items dan update stok
            foreach ($items as $item) {
                $product  = Product::find($item['product_id']);
                $harga    = $product->harga_jual;
                $quantity = $item['quantity'];

                OrderItem::create([
                    'order_id'        => $order->id,
                    'product_id'      => $product->id,
                    'quantity'        => $quantity,
                    'harga_saat_beli' => $harga,
                    'diskon_item'     => 0,
                ]);

                // Update stok produk
                $product->decrement('stok', $quantity);
            }

            // Update poin member
            if ($memberId && $poinBertambah > 0) {
                $member = Member::find($memberId);
                if ($member) {
                    $member->increment('poin', $poinBertambah);
                }
            }

            // Hitung kembalian
            $kembalian = $uangDibayar - $totalBayar;

            DB::commit();

            return response()->json([
                'success'           => true,
                'message'           => 'Transaksi berhasil diproses!',
                'order_id'          => $order->id,
                'subtotal'          => $subtotal,
                'total_diskon'      => $totalDiskon,
                'total_bayar'       => $totalBayar,
                'uang_dibayar'      => $uangDibayar,
                'kembalian'         => $kembalian,
                'poin_bertambah'    => $poinBertambah,
                'metode_pembayaran' => $metodePembayaran, // PASTIKAN INI ADA
                'invoice_url'       => route('pos.invoice', $order->id),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    // Get product details untuk AJAX
    public function getProduct($id)
    {
        if (! Auth::check() || (! Auth::user()->isKasir() && ! Auth::user()->isOwner() && ! Auth::user()->isAdmin())) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        $product = Product::with('kategori')->find($id);

        if (! $product) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json([
            'id'              => $product->id,
            'nama_produk'     => $product->nama_produk,
            'harga_jual'      => $product->harga_jual,
            'stok'            => $product->stok,
            'kategori'        => $product->kategori ? $product->kategori->nama_kategori : 'Tidak ada kategori',
            'harga_formatted' => 'Rp ' . number_format($product->harga_jual, 0, ',', '.'),
        ]);
    }

    // Tampilkan invoice
    public function showInvoice($id)
    {
        if (! Auth::check() || (! Auth::user()->isKasir() && ! Auth::user()->isOwner() && ! Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $order = Order::with(['orderItems.product', 'user', 'member'])->findOrFail($id);
        return view('pos.invoice', compact('order'));
    }

    // Method untuk cek inventory
    public function checkInventory()
    {
        if (! Auth::check() || (! Auth::user()->isKasir() && ! Auth::user()->isOwner() && ! Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        return view('inventory_check');
    }

    // Method untuk pencarian produk di inventory check
    public function searchInventory(Request $request)
    {
        if (! Auth::check() || (! Auth::user()->isKasir() && ! Auth::user()->isOwner() && ! Auth::user()->isAdmin())) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        $searchTerm = $request->get('q');

        $products = Product::with('kategori')
            ->where(function ($query) use ($searchTerm) {
                $query->where('nama_produk', 'like', '%' . $searchTerm . '%')
                    ->orWhere('barcode', 'like', '%' . $searchTerm . '%');
            })
            ->orderBy('nama_produk')
            ->get();

        return response()->json($products);
    }

    // Method untuk mendapatkan detail produk di inventory check
    public function getInventoryProductDetail($id)
    {
        if (! Auth::check() || (! Auth::user()->isKasir() && ! Auth::user()->isOwner() && ! Auth::user()->isAdmin())) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        $product = Product::with('kategori')->find($id);

        if (! $product) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json($product);
    }

    // Method lain yang sudah ada
    public function manageDiscounts()
    {
        if (! Auth::check() || (! Auth::user()->isKasir() && ! Auth::user()->isOwner() && ! Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        return view('discount_management');
    }

    public function cashierReport()
    {
        if (! Auth::check() || (! Auth::user()->isKasir() && ! Auth::user()->isOwner() && ! Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        return view('cashier_report');
    }

    private function calculateWholesalePrice($product, $quantity)
    {
        $harga_normal = $product->harga_jual;

        // Pastikan wholesale_rules berupa array
        $wholesale_rules = $product->wholesale_rules;
        if (! is_array($wholesale_rules)) {
            $wholesale_rules = json_decode($wholesale_rules, true) ?? [];
        }

        // Cek aturan grosir
        if (! empty($wholesale_rules)) {
            // Urutkan dari quantity terbesar
            usort($wholesale_rules, function ($a, $b) {
                return $b['min_quantity'] - $a['min_quantity'];
            });

            // Cari rule yang sesuai
            foreach ($wholesale_rules as $rule) {
                if ($quantity >= $rule['min_quantity']) {
                    $diskon = $harga_normal * ($rule['discount_percent'] / 100);
                    return $harga_normal - $diskon;
                }
            }
        }

        return $harga_normal;
    }

}
