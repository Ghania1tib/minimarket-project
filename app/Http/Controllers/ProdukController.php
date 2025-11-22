<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function __construct()
    {
        // Langkah 4: Middleware auth untuk proteksi halaman
        $this->middleware('auth');
    }

    public function index()
    {
        // Langkah 4: Cek authentication dan role
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(12);
        return view('produk.index', compact('products'));
    }

    public function create()
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $categories = Category::all();
        return view('produk.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        // Validasi data
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'nullable|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_kritis' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Handle upload gambar
            $gambar_url = null;
            if ($request->hasFile('gambar')) {
                $gambar_url = $request->file('gambar')->store('products', 'public');
            }

            // Create product
            Product::create([
                'nama_produk' => $request->nama_produk,
                'category_id' => $request->category_id,
                'barcode' => $request->barcode,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'stok' => $request->stok,
                'stok_kritis' => $request->stok_kritis,
                'deskripsi' => $request->deskripsi,
                'gambar_url' => $gambar_url
            ]);

            return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $product = Product::with('category')->findOrFail($id);
        return view('produk.show', compact('product'));
    }

    public function edit($id)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('produk.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $product = Product::findOrFail($id);

        // Validasi data
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'nullable|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_kritis' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $data = [
                'nama_produk' => $request->nama_produk,
                'category_id' => $request->category_id,
                'barcode' => $request->barcode,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'stok' => $request->stok,
                'stok_kritis' => $request->stok_kritis,
                'deskripsi' => $request->deskripsi,
            ];

            // Handle upload gambar baru
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($product->gambar_url && Storage::disk('public')->exists($product->gambar_url)) {
                    Storage::disk('public')->delete($product->gambar_url);
                }

                $data['gambar_url'] = $request->file('gambar')->store('products', 'public');
            }

            // Update product
            $product->update($data);

            return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        try {
            $product = Product::findOrFail($id);

            // Hapus gambar jika ada
            if ($product->gambar_url && Storage::disk('public')->exists($product->gambar_url)) {
                Storage::disk('public')->delete($product->gambar_url);
            }

            $product->delete();

            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $keyword = $request->get('keyword');

        $products = Product::with('category')
            ->where('nama_produk', 'like', "%{$keyword}%")
            ->orWhere('barcode', 'like', "%{$keyword}%")
            ->orWhereHas('category', function($query) use ($keyword) {
                $query->where('nama_kategori', 'like', "%{$keyword}%");
            })
            ->paginate(12);

        return view('produk.index', compact('products', 'keyword'));
    }
}
