<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'nama_produk' => 'Beras Premium 5kg',
                'category_id' => 1,
                'barcode' => '1234567890123',
                'harga_beli' => 60000,
                'harga_jual' => 75000,
                'stok' => 100,
                'stok_kritis' => 10,
                'deskripsi' => 'Beras premium kualitas terbaik'
            ],
            [
                'nama_produk' => 'Minyak Goreng 2L',
                'category_id' => 1,
                'barcode' => '1234567890124',
                'harga_beli' => 25000,
                'harga_jual' => 32000,
                'stok' => 50,
                'stok_kritis' => 5,
                'deskripsi' => 'Minyak goreng sawit'
            ],
            [
                'nama_produk' => 'Aqua 600ml',
                'category_id' => 2,
                'barcode' => '1234567890125',
                'harga_beli' => 3000,
                'harga_jual' => 5000,
                'stok' => 200,
                'stok_kritis' => 20,
                'deskripsi' => 'Air mineral'
            ],
            [
                'nama_produk' => 'Coca-Cola 330ml',
                'category_id' => 2,
                'barcode' => '1234567890126',
                'harga_beli' => 6000,
                'harga_jual' => 8000,
                'stok' => 150,
                'stok_kritis' => 15,
                'deskripsi' => 'Minuman bersoda'
            ],
            [
                'nama_produk' => 'Chitato 100gr',
                'category_id' => 3,
                'barcode' => '1234567890127',
                'harga_beli' => 8000,
                'harga_jual' => 12000,
                'stok' => 80,
                'stok_kritis' => 8,
                'deskripsi' => 'Chip kentang'
            ],
            [
                'nama_produk' => 'Lifebuoy Sabun Mandi',
                'category_id' => 4,
                'barcode' => '1234567890128',
                'harga_beli' => 5000,
                'harga_jual' => 7000,
                'stok' => 60,
                'stok_kritis' => 6,
                'deskripsi' => 'Sabun mandi anti bakteri'
            ],
            [
                'nama_produk' => 'Indomie Goreng',
                'category_id' => 3,
                'barcode' => '1234567890129',
                'harga_beli' => 2500,
                'harga_jual' => 3500,
                'stok' => 200,
                'stok_kritis' => 20,
                'deskripsi' => 'Mi instan goreng'
            ],
            [
                'nama_produk' => 'Sunlight 450ml',
                'category_id' => 5,
                'barcode' => '1234567890130',
                'harga_beli' => 8000,
                'harga_jual' => 11000,
                'stok' => 40,
                'stok_kritis' => 5,
                'deskripsi' => 'Sabun cuci piring'
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['barcode' => $product['barcode']],
                $product
            );
        }

        $this->command->info('Products seeded successfully!');
    }
}
