<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbsenceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('absences')->insert([
            [
                'siswa_id' => 1, // Ini Id si Ahmad Fauzi (karena dia masuk duluan tadi)
                'tanggal' => date('Y-m-d'),
                'jam_masuk' => '06:45:00',
                'status' => 'Hadir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 2, // Ini Id si Siti Aminah
                'tanggal' => date('Y-m-d'),
                'jam_masuk' => '07:15:00',
                'status' => 'Terlambat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}