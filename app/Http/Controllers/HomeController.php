<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Kategori;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Ambil parameter pencarian dan filter
            $search = $request->input('search');
            $category_id = $request->input('category_id');

            // Query untuk produk dengan eager loading kategori
            $productsQuery = Product::with(['kategori' => function($query) {
                $query->active();
            }])->available();

            // Filter berdasarkan pencarian
            if ($search) {
                $productsQuery->where(function($query) use ($search) {
                    $query->where('nama_produk', 'LIKE', "%{$search}%")
                          ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                          ->orWhere('barcode', 'LIKE', "%{$search}%");
                });
            }

            // Filter berdasarkan kategori
            if ($category_id) {
                $productsQuery->where('category_id', $category_id);
            }

            // Pagination dengan 12 item per halaman
            $products = $productsQuery->orderBy('created_at', 'desc')->paginate(12);

            // Ambil semua kategori aktif untuk dropdown
            $kategories = Kategori::active()->withCount(['products' => function($query) {
                $query->available();
            }])->get();

            // Hitung total produk dan kategori untuk stats
            $totalProducts = Product::available()->count();
            $totalKategories = Kategori::active()->has('products')->count();

            return view('welcome', compact(
                'products',
                'kategories',
                'totalProducts',
                'totalKategories',
                'search',
                'category_id'
            ));

        } catch (\Exception $e) {
            // Fallback jika ada error
            \Log::error('Error in HomeController: ' . $e->getMessage());

            $products = collect();
            $kategories = collect();
            $totalProducts = 0;
            $totalKategories = 0;
            $search = $request->input('search');
            $category_id = $request->input('category_id');

            return view('welcome', compact(
                'products',
                'kategories',
                'totalProducts',
                'totalKategories',
                'search',
                'category_id'
            ));
        }
    }
}
