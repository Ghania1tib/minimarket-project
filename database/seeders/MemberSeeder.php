<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'kode_member' => 'MMB001',
                'nama_lengkap' => 'John Doe',
                'nomor_telepon' => '081234567894',
                'tanggal_daftar' => now(),
                'poin' => 100,
            ],
            [
                'kode_member' => 'MMB002',
                'nama_lengkap' => 'Jane Smith',
                'nomor_telepon' => '081234567895',
                'tanggal_daftar' => now(),
                'poin' => 50,
            ],
            [
                'kode_member' => 'MMB003',
                'nama_lengkap' => 'Bob Johnson',
                'nomor_telepon' => '081234567896',
                'tanggal_daftar' => now(),
                'poin' => 200,
            ],
            [
                'kode_member' => 'MMB004',
                'nama_lengkap' => 'Alice Brown',
                'nomor_telepon' => '081234567897',
                'tanggal_daftar' => now(),
                'poin' => 75,
            ],
            [
                'kode_member' => 'MMB005',
                'nama_lengkap' => 'Charlie Wilson',
                'nomor_telepon' => '081234567898',
                'tanggal_daftar' => now(),
                'poin' => 150,
            ],
        ];

        foreach ($members as $member) {
            Member::updateOrCreate(
                ['kode_member' => $member['kode_member']],
                $member
            );
        }

        $this->command->info('Members seeded successfully!');
    }
}
