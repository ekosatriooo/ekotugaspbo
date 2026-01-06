<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Ini buat bikin User Admin biar lo bisa login
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'), // Passwordnya jadi: password
            'role' => 'admin',
        ]);

        // 2. Ini kita panggil seeder Siswa & Absensi yang kita buat tadi
        $this->call([
            SiswaSeeder::class,
            AbsenceSeeder::class,
        ]);
    }
}