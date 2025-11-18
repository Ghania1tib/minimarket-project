<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            // POPULAR PRODUCTS
            [
                'name' => 'Apel Segar',
                'description' => 'Apel merah manis segar langsung dari kebun',
                'price' => 25000,
                'image_url' => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=400&h=300&fit=crop',
                'rating' => 4.5,
                'reviews' => 120,
                'category' => 'Buah & Sayur',
                'stock' => 50
            ],
            [
                'name' => 'Pisang Organik',
                'description' => 'Pisang segar organik tanpa pestisida',
                'price' => 28000,
                'image_url' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=400&h=300&fit=crop',
                'rating' => 4.3,
                'reviews' => 89,
                'category' => 'Buah & Sayur',
                'stock' => 75
            ],
            [
                'name' => 'Wortel Segar',
                'description' => 'Wortel organik segar kaya vitamin A',
                'price' => 8000,
                'image_url' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=400&h=300&fit=crop',
                'rating' => 4.7,
                'reviews' => 156,
                'category' => 'Buah & Sayur',
                'stock' => 100
            ],
            [
                'name' => 'Tomat Premium',
                'description' => 'Tomat merah premium rasa manis segar',
                'price' => 14000,
                'image_url' => 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=400&h=300&fit=crop',
                'rating' => 4.4,
                'reviews' => 67,
                'category' => 'Buah & Sayur',
                'stock' => 60
            ],

            // FLASH SALE PRODUCTS
            [
                'name' => 'Brokoli Segar',
                'description' => 'Brokoli hijau segar kaya nutrisi',
                'price' => 12000,
                'original_price' => 18000,
                'discount_percent' => 33,
                'image_url' => 'https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?w=400&h=300&fit=crop',
                'rating' => 4.6,
                'reviews' => 92,
                'category' => 'Buah & Sayur',
                'is_flash_sale' => true,
                'sold_count' => 45,
                'stock' => 30
            ],
            [
                'name' => 'Jeruk Manis',
                'description' => 'Jeruk orange manis segar kaya vitamin C',
                'price' => 29000,
                'original_price' => 35000,
                'discount_percent' => 17,
                'image_url' => 'https://images.unsplash.com/photo-1557800636-894a64c1696f?w=400&h=300&fit=crop',
                'rating' => 4.8,
                'reviews' => 200,
                'category' => 'Buah & Sayur',
                'is_flash_sale' => true,
                'sold_count' => 78,
                'stock' => 40
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}