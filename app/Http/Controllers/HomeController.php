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
            $show_all = $request->input('show_all', false);

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

            // Check if AJAX request
            if ($request->ajax() || $request->has('ajax')) {
                $page = $request->input('page', 1);
                $show_all = $request->input('show_all', false);

                // Jika show_all true, tampilkan semua produk tanpa pagination
                if ($show_all) {
                    $products = $productsQuery->orderBy('created_at', 'desc')->get();

                    // Return view untuk product cards
                    $html = '';
                    if ($products->count() > 0) {
                        foreach ($products as $product) {
                            $html .= view('layouts.partials.product-card', compact('product'))->render();
                        }
                    }

                    return response()->json([
                        'success' => true,
                        'html' => $html,
                        'hasMorePages' => false,
                        'nextPage' => null,
                        'showAll' => true,
                        'totalProducts' => $products->count()
                    ]);
                } else {
                    // Normal pagination
                    $products = $productsQuery->orderBy('created_at', 'desc')->paginate(12, ['*'], 'page', $page);

                    // Return view untuk product cards
                    $html = '';
                    if ($products->count() > 0) {
                        foreach ($products as $product) {
                            $html .= view('layouts.partials.product-card', compact('product'))->render();
                        }
                    }

                    return response()->json([
                        'success' => true,
                        'html' => $html,
                        'hasMorePages' => $products->hasMorePages(),
                        'nextPage' => $products->currentPage() + 1,
                        'showAll' => false,
                        'totalProducts' => $products->total()
                    ]);
                }
            }

            // Normal request - pagination, tampilkan hanya 12 produk pertama
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
            \Log::error('Error in HomeController: ' . $e->getMessage());

            if ($request->ajax() || $request->has('ajax')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }

            $products = Product::query()->paginate(12);
            $kategories = Kategori::active()->get();
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
