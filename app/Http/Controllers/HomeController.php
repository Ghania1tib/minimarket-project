<?php
namespace App\Http\Controllers;

use App\Models\Produk;

class HomeController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->latest()->take(8)->get();

        $heroBanners = [
            [
                'title'    => 'Diskon Besar Akhir Pekan',
                'subtitle' => 'Hemat hingga 50% untuk semua kebutuhan dapur!',
                'link'     => '/promosi/weekend',
            ],
            [
                'title'    => 'Gratis Ongkir',
                'subtitle' => 'Minimum belanja Rp150.000, kirim cepat dan aman.',
                'link'     => '/promo/ongkir',
            ],
        ];

        $flashSaleEndsAt = now()->addHours(3)->addMinutes(15);
        $now             = now();

        $countdownString = '00:00:00';

        if ($flashSaleEndsAt->greaterThan($now)) {

            $selisihWaktu = $flashSaleEndsAt->diff($now);

            $countdownString = $selisihWaktu->format('%H:%I:%S');
        }

        $flashSaleProducts = [
            ['name' => 'Minyak Goreng 2L', 'price' => 35000, 'discount_price' => 29900],
            ['name' => 'Telur Ayam 1 Tray', 'price' => 52000, 'discount_price' => 45500],
            ['name' => 'Deterjen Cair 800ml', 'price' => 25000, 'discount_price' => 19900],
            ['name' => 'Apel Fuji Segar (1 Kg)', 'price' => 40000, 'discount_price' => 32000],
        ];

        $popularCategories = [
            ['name' => 'Buah & Sayur', 'icon' => '🍎', 'link' => '/kategori/sayur'],
            ['name' => 'Daging & Seafood', 'icon' => '🥩', 'link' => '/kategori/daging'],
            ['name' => 'Makanan Beku', 'icon' => '❄️', 'link' => '/kategori/frozen'],
            ['name' => 'Bumbu Dapur', 'icon' => '🌶️', 'link' => '/kategori/bumbu'],
        ];

        return view('welcome', compact(
            'produk',
            'countdownString',
            'heroBanners',
            'flashSaleProducts',
            'popularCategories'
        ));
    }
}

