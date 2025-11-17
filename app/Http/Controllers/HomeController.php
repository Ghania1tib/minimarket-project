<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Data banner untuk carousel
        $heroBanners = [
            [
                'title' => 'Promo Spesial Akhir Tahun',
                'subtitle' => 'Dapatkan diskon hingga 50% untuk semua produk!',
                'link' => '#',
                'color' => '#004f7c'
            ],
            [
                'title' => 'Gratis Ongkir',
                'subtitle' => 'Minimal pembelian Rp 100.000',
                'link' => '#',
                'color' => '#ff6347'
            ],
            [
                'title' => 'New Product Launch',
                'subtitle' => 'Temukan produk terbaru kami',
                'link' => '#',
                'color' => '#ffb6c1'
            ]
        ];

        // PERBAIKAN: Gunakan placeholder yang valid
        $flashSaleProducts = [
            [
                'id' => 1,
                'name' => 'Minyak Goreng 2L',
                'price' => 35000,
                'discount_rate' => 20,
                'discount_price' => 28000,
                'img_url' => $this->generatePlaceholderSvg('Minyak Goreng'), // PERBAIKAN: Gunakan SVG
                'link' => '#',
                'category_name' => 'Bahan Pokok'
            ],
            [
                'id' => 2,
                'name' => 'Beras Premium 5kg',
                'price' => 75000,
                'discount_rate' => 15,
                'discount_price' => 63750,
                'img_url' => $this->generatePlaceholderSvg('Beras Premium'),
                'link' => '#',
                'category_name' => 'Bahan Pokok'
            ],
            [
                'id' => 3,
                'name' => 'Sabun Mandi 6pcs',
                'price' => 30000,
                'discount_rate' => 25,
                'discount_price' => 22500,
                'img_url' => $this->generatePlaceholderSvg('Sabun Mandi'),
                'link' => '#',
                'category_name' => 'Perawatan Diri'
            ],
            [
                'id' => 4,
                'name' => 'Shampoo Anti Ketombe',
                'price' => 25000,
                'discount_rate' => 30,
                'discount_price' => 17500,
                'img_url' => $this->generatePlaceholderSvg('Shampoo'),
                'link' => '#',
                'category_name' => 'Perawatan Diri'
            ]
        ];

        // Countdown untuk flash sale
        $countdownString = "23:59:59";

        // Kategori populer dari database
        try {
            $popularCategories = Category::select('categories.*')
                ->addSelect(DB::raw('(SELECT COUNT(*) FROM products WHERE categories.id = products.category_id) as products_count'))
                ->orderBy('products_count', 'desc')
                ->take(6)
                ->get();
        } catch (\Exception $e) {
            // Fallback jika query di atas error
            $popularCategories = Category::withCount(['products' => function($query) {
                $query->whereNotNull('category_id');
            }])
            ->orderBy('products_count', 'desc')
            ->take(6)
            ->get();
        }

        // Jika masih kosong, ambil semua kategori tanpa count
        if ($popularCategories->isEmpty()) {
            $popularCategories = Category::take(6)->get();

            // Tambahkan products_count manual
            foreach ($popularCategories as $category) {
                $category->products_count = $category->products()->count();
            }
        }

        // Produk unggulan dari database - PERBAIKAN: Tambahkan fallback untuk gambar
        $produkUnggulan = Product::where('stok', '>', 0)
            ->with(['category' => function($query) {
                $query->select('id', 'nama_kategori');
            }])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get()
            ->map(function ($product) {
                // PERBAIKAN: Tambahkan fallback untuk gambar yang tidak valid
                if (empty($product->full_gambar_url) || !filter_var($product->full_gambar_url, FILTER_VALIDATE_URL)) {
                    $product->full_gambar_url = $this->generatePlaceholderSvg($product->nama_produk);
                }
                return $product;
            });

        // Fallback jika produk unggulan kosong
        if ($produkUnggulan->isEmpty()) {
            $produkUnggulan = collect();
        }

        return view('welcome', compact(
            'heroBanners',
            'flashSaleProducts',
            'countdownString',
            'popularCategories',
            'produkUnggulan'
        ));
    }

    // PERBAIKAN: Method untuk generate placeholder SVG
    private function generatePlaceholderSvg($text)
    {
        $encodedText = urlencode($text);
        return "data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='150' viewBox='0 0 200 150'%3E%3Crect width='200' height='150' fill='%23f8f9fa'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='Arial, sans-serif' font-size='14' fill='%236c757d'%3E" . $encodedText . "%3C/text%3E%3C/svg%3E";
    }

    // Method untuk API
    public function getFeaturedProducts()
    {
        $products = Product::where('stok', '>', 0)
            ->with(['category' => function($query) {
                $query->select('id', 'nama_kategori');
            }])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return response()->json($products);
    }

    public function getPopularCategories()
    {
        try {
            $categories = Category::select('categories.*')
                ->addSelect(DB::raw('(SELECT COUNT(*) FROM products WHERE categories.id = products.category_id) as products_count'))
                ->orderBy('products_count', 'desc')
                ->take(6)
                ->get();
        } catch (\Exception $e) {
            $categories = Category::withCount('products')
                ->orderBy('products_count', 'desc')
                ->take(6)
                ->get();
        }

        return response()->json($categories);
    }
}
