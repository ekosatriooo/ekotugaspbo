<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas'; // Nama tabel di database

    // Daftarkan kolom yang BOLEH diisi secara massal
    protected $fillable = [
        'kelas',
        'nama_kelas',
        'jurusan',
    ];
}
