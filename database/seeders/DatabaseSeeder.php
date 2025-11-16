<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Owner Minimarket',
            'email' => 'owner@minimarket.com',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'no_telepon' => '081234567890',
            'alamat' => 'Alamat owner minimarket'
        ]);

        User::create([
            'nama_lengkap' => 'Kasir Minimarket',
            'email' => 'kasir@minimarket.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
            'no_telepon' => '081234567891',
            'alamat' => 'Alamat kasir minimarket'
        ]);

        User::create([
            'nama_lengkap' => 'Admin Minimarket',
            'email' => 'admin@minimarket.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'no_telepon' => '081234567892',
            'alamat' => 'Alamat admin minimarket'
        ]);

        // User customer contoh
        User::create([
            'nama_lengkap' => 'Pelanggan Contoh',
            'email' => 'customer@minimarket.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'no_telepon' => '081234567893',
            'alamat' => 'Alamat pelanggan contoh'
        ]);

        $this->command->info('User seeder berhasil ditambahkan!');
        $this->command->info('Email: owner@minimarket.com / Password: password123 (Owner)');
        $this->command->info('Email: kasir@minimarket.com / Password: password123 (Kasir)');
        $this->command->info('Email: admin@minimarket.com / Password: password123 (Admin)');
        $this->command->info('Email: customer@minimarket.com / Password: password123 (Customer)');
    }
}
