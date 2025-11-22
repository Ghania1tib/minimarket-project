<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Bahan Pokok'],
            ['nama_kategori' => 'Minuman'],
            ['nama_kategori' => 'Makanan Ringan'],
            ['nama_kategori' => 'Perawatan Diri'],
            ['nama_kategori' => 'Peralatan Rumah Tangga'],
            ['nama_kategori' => 'Buah dan Sayur'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['nama_kategori' => $category['nama_kategori']],
                $category
            );
        }

        $this->command->info('Categories seeded successfully!');
    }
}
