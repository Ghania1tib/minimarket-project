<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil 8 Produk Unggulan/Terbaru
        // FIX: Menggunakan relasi 'category' yang benar.
        $produkUnggulan = Product::with('category')->latest()->take(8)->get();

        // 2. Ambil Kategori Populer (hanya yang memiliki produk)
        $popularCategories = Category::withCount('products')
                                    ->has('products')
                                    ->orderBy('products_count', 'desc')
                                    ->take(6)
                                    ->get();

        // 3. Data Flash Sale (Untuk demo, menggunakan data statis yang diolah agar tampak dinamis)
        // Jika Anda memiliki tabel 'promos' yang aktif dan menargetkan produk, Anda bisa mengambilnya dari sana.
        // Untuk sementara, kita ambil 4 produk dengan diskon fiktif.
        $flashSaleProducts = Product::latest()->take(4)->get()->map(function ($product) {
            $discountRate = rand(10, 25) / 100;
            $discountPrice = $product->harga_jual * (1 - $discountRate);

            return [
                'id' => $product->id,
                'name' => $product->nama_produk,
                'price' => $product->harga_jual,
                'discount_price' => round($discountPrice, 0, PHP_ROUND_HALF_UP),
                'discount_rate' => round($discountRate * 100),
                'img_url' => asset('storage/' . $product->gambar_url),
                'category_name' => $product->category->nama_kategori ?? 'Umum',
                'link' => route('produk.show', $product->id)
            ];
        });

        // 4. Data Banner (statis)
        $heroBanners = [
            [
                'title'    => 'Diskon Besar Akhir Pekan',
                'subtitle' => 'Hemat hingga 50% untuk semua kebutuhan dapur!',
                'link'     => '/promosi/weekend',
                'color'    => '#004f7c', // Warna Biru
            ],
            [
                'title'    => 'Gratis Ongkir Super Cepat',
                'subtitle' => 'Minimum belanja Rp150.000, kirim cepat dan aman ke seluruh wilayah!',
                'link'     => '/promo/ongkir',
                'color'    => '#ff6347', // Warna Merah/Accent
            ],
        ];

        // 5. Hitung Countdown (statis, 3 jam dari sekarang)
        $flashSaleEndsAt = now()->addHours(3)->addMinutes(15);
        $now             = now();
        $countdownString = '00:00:00';

        if ($flashSaleEndsAt->greaterThan($now)) {
            $selisihWaktu = $flashSaleEndsAt->diff($now);
            $countdownString = $selisihWaktu->format('%H:%I:%S');
        }

        return view('welcome', compact(
            'produkUnggulan',
            'countdownString',
            'heroBanners',
            'flashSaleProducts',
            'popularCategories'
        ));
    }
}
