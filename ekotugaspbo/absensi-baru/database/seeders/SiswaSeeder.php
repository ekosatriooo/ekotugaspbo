<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('siswa')->insert([
            [
                'nis' => '1001',
                'nama' => 'Ahmad Fauzi',
                'kelas' => 'XII RPL 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '1002',
                'nama' => 'Siti Aminah',
                'kelas' => 'XII RPL 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '1003',
                'nama' => 'Budi Santoso',
                'kelas' => 'XI TKJ 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}