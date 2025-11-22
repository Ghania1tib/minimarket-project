<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promos = [
            [
                'kode_promo' => 'DISKON10',
                'nama_promo' => 'Diskon 10%',
                'deskripsi' => 'Diskon 10% untuk semua produk',
                'jenis_promo' => 'diskon_persentase',
                'nilai_promo' => 10,
                'tanggal_mulai' => now(),
                'tanggal_berakhir' => now()->addDays(30),
                'kuota' => 100,
                'digunakan' => 0,
                'minimal_pembelian' => 50000,
                'maksimal_diskon' => 20000,
                'status' => true,
            ],
            [
                'kode_promo' => 'DISKON20K',
                'nama_promo' => 'Diskon Rp 20.000',
                'deskripsi' => 'Potongan langsung Rp 20.000',
                'jenis_promo' => 'diskon_nominal',
                'nilai_promo' => 20000,
                'tanggal_mulai' => now(),
                'tanggal_berakhir' => now()->addDays(15),
                'kuota' => 50,
                'digunakan' => 0,
                'minimal_pembelian' => 100000,
                'maksimal_diskon' => null,
                'status' => true,
            ],
            [
                'kode_promo' => 'NEWMEMBER',
                'nama_promo' => 'Promo Member Baru',
                'deskripsi' => 'Diskon 15% untuk member baru',
                'jenis_promo' => 'diskon_persentase',
                'nilai_promo' => 15,
                'tanggal_mulai' => now(),
                'tanggal_berakhir' => now()->addDays(60),
                'kuota' => 200,
                'digunakan' => 0,
                'minimal_pembelian' => 30000,
                'maksimal_diskon' => 25000,
                'status' => true,
            ],
        ];

        foreach ($promos as $promo) {
            Promo::updateOrCreate(
                ['kode_promo' => $promo['kode_promo']],
                $promo
            );
        }

        $this->command->info('Promos seeded successfully!');
    }
}
