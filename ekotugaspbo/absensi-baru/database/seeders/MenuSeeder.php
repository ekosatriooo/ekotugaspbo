<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
        ['name' => 'Kelola Menu', 'slug' => 'kelola_menu'],
        ['name' => 'Kelola Absensi', 'slug' => 'kelola_absensi'],
        ['name' => 'Siswa', 'slug' => 'siswa'],
        ['name' => 'Users', 'slug' => 'users'],
        ['name' => 'Api Config', 'slug' => 'api_config'],
    ];

    foreach ($data as $item) {
        \App\Models\Menu::create($item);
    }
    }
}
