<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nama_lengkap' => 'Super Admin',
                'email' => 'admin@minimarket.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'no_telepon' => '081234567890',
                'alamat' => 'Jl. Admin No. 1'
            ],
            [
                'nama_lengkap' => 'Pemilik Toko',
                'email' => 'owner@minimarket.com',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'no_telepon' => '081234567891',
                'alamat' => 'Jl. Owner No. 1'
            ],
            [
                'nama_lengkap' => 'Kasir Toko',
                'email' => 'kasir@minimarket.com',
                'password' => Hash::make('password123'),
                'role' => 'kasir',
                'no_telepon' => '081234567892',
                'alamat' => 'Jl. Kasir No. 1'
            ],
            [
                'nama_lengkap' => 'Pelanggan Contoh',
                'email' => 'customer@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'no_telepon' => '081234567893',
                'alamat' => 'Jl. Pelanggan No. 1'
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']], // Cari berdasarkan email
                $user // Update atau create data
            );
        }

        $this->command->info('Users seeded successfully!');
    }
}
