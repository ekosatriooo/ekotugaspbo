<?php

namespace App\Models;
use App\Models\Kelas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa'; 
    protected $fillable = ['nis', 'nama', 'jenis_kelamin', 'kelas', 'no_hp', 'alamat', 'tanggal_lahir'];

    
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    public function kelas_relasi()
{
    return $this->belongsTo(Kelas::class, 'kelas', 'id');
}

// Ini untuk "menyelamatkan" Rekap yang mungkin pakai CamelCase
public function kelasRelasi()
{
    return $this->kelas_relasi();
}
}