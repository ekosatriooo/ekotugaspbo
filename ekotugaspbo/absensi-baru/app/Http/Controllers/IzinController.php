<?php

namespace App\Http\Controllers; // <--- WAJIB ADA BARIS INI

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\Absensi;
use Carbon\Carbon;

class IzinController extends Controller
{
    public function index()
    {
        // Pastikan model Izin diimport atau dipanggil lengkap
        $data_izin = Izin::with(['siswa.kelas_relasi'])->orderBy('created_at', 'desc')->get();
        return view('admin.menu.izin', compact('data_izin'));
    }

    public function setujui($id)
{
    $izin = Izin::findOrFail($id);
    
    // 1. Ubah status di tabel izin
    $izin->update(['status' => 'Disetujui']);

    // 2. MASUKKAN KE TABEL ABSENSI (Supaya muncul di Rekap)
    \App\Models\Absensi::updateOrCreate(
        [
            'siswa_id' => $izin->siswa_id,
            'tanggal'  => $izin->tanggal_mulai, 
        ],
        [
            'status'     => $izin->jenis_izin, // 'Izin' atau 'Sakit'
            'keterangan' => $izin->keterangan, // Alasan dari siswa
            'jam_masuk'  => null, 
            'jam_pulang' => null,
        ]
    );

    return back()->with('success', 'Izin disetujui dan sudah masuk ke Rekap Absensi!');
}

    public function tolak($id)
{
    $izin = Izin::findOrFail($id);
    
    // 1. Update status di tabel izin jadi Ditolak
    $izin->update(['status' => 'Ditolak']);

    // 2. Masukkan ke tabel Absensi sebagai ALPA
    // Ini supaya data tetap muncul di rekap tapi statusnya merah (Alpa)
    \App\Models\Absensi::updateOrCreate(
        [
            'siswa_id' => $izin->siswa_id,
            'tanggal'  => $izin->tanggal_mulai, 
        ],
        [
            'status'     => 'Alpa', // Paksa jadi Alpa karena ditolak
            'keterangan' => 'Permohonan izin ditolak admin. Alasan asli: ' . $izin->keterangan,
            'jam_masuk'  => null, 
            'jam_pulang' => null,
        ]
    );

    return back()->with('info', 'Izin ditolak dan tercatat sebagai Alpa di absensi.');
}
}