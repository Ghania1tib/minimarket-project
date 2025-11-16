<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('produk.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('produk.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama_produk' => 'required|string|max:150',
            'barcode' => 'nullable|string|max:50|unique:products',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_kritis' => 'required|integer|min:0'
        ]);

        $gambarUrl = null;
        if ($request->hasFile('gambar')) {
            $gambarUrl = $request->file('gambar')->store('products', 'public');
        }

        Product::create([
            'category_id' => $request->category_id,
            'nama_produk' => $request->nama_produk,
            'barcode' => $request->barcode,
            'deskripsi' => $request->deskripsi,
            'gambar_url' => $gambarUrl,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'stok_kritis' => $request->stok_kritis
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('produk.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('produk.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama_produk' => 'required|string|max:150',
            'barcode' => 'nullable|string|max:50|unique:products,barcode,' . $id,
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_kritis' => 'required|integer|min:0'
        ]);

        $gambarUrl = $product->gambar_url;
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($gambarUrl) {
                Storage::disk('public')->delete($gambarUrl);
            }
            $gambarUrl = $request->file('gambar')->store('products', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'nama_produk' => $request->nama_produk,
            'barcode' => $request->barcode,
            'deskripsi' => $request->deskripsi,
            'gambar_url' => $gambarUrl,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'stok_kritis' => $request->stok_kritis
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar jika ada
        if ($product->gambar_url) {
            Storage::disk('public')->delete($product->gambar_url);
        }

        $product->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        if (!$keyword) {
            return redirect()->route('produk.index');
        }

        $products = Product::where('nama_produk', 'LIKE', "%{$keyword}%")
                          ->orWhere('barcode', 'LIKE', "%{$keyword}%")
                          ->with('category')
                          ->paginate(12);

        return view('produk.search_results', compact('products', 'keyword'));
    }
}
