<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    
    protected $table = 'absensi';

    protected $fillable = [
        'siswa_id',
        'status',
        'tanggal',
        'jam_masuk', 
        'jam_pulang',
        'status',
        'alasan'
    ];
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function kelas_relasi() {
    return $this->belongsTo(Kelas::class, 'kelas'); // 'kelas' adalah foreign key-nya
}
}