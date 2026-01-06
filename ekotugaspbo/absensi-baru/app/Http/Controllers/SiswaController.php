<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SiswaController extends Controller
{
    // === FUNGSI ADMIN (DATABASE SISWA) ===
    public function index()
    {
        $siswa = Siswa::orderBy('nama', 'asc')->get();
        return view('admin.menu.siswa', compact('siswa'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Super Ketat
        $request->validate([
            'nis' => 'required|unique:siswa,nis', // Cek di tabel 'siswa' kolom 'nis'
            'nama' => 'required|string|max:255',
            'kelas' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date', // Tambahkan ini agar tidak kosong
            'no_hp' => 'numeric', 
            'alamat' => 'string|max:500',
        ], [
            // Pesan error bahasa Indonesia (biar user paham)
            'nis.required' => 'NIS wajib diisi!',
            'nis.unique' => 'NIS ini sudah terdaftar, gunakan NIS lain!',
            'nama.required' => 'Nama siswa jangan dikosongkan!',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi untuk keperluan data!',
            'kelas.required' => 'Silahkan pilih kelas terlebih dahulu!',
            'jenis_kelamin.required' => 'Silahkan masukkan jenis kelamin!',
            'no_hp.numeric' => 'Silahkan masukkan nomor hp',
            'alamat.string' => 'Silahkan masukkan alamat!',
        ]);

        // 2. Simpan Data
        Siswa::create($request->all());

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
{
    // 1. Pastikan ID ada
    $siswa = Siswa::findOrFail($id);

    // 2. Validasi
    $request->validate([
        // 'unique:nama_tabel,nama_kolom,ID_yang_dikecualikan'
        'nis' => 'required|unique:siswa,nis,' . $id,
        'nama' => 'required|string|max:255',
        'kelas' => 'required',
        'jenis_kelamin' => 'required|in:L,P',
        'tanggal_lahir' => 'required|date', 
    ], [
        'nis.unique' => 'Gagal Update! NIS ini sudah dipakai siswa lain.',
        'nis.required' => 'NIS tidak boleh kosong!',
        'tanggal_lahir.required' => 'Tanggal lahir tidak boleh kosong!',
    ]);

    // 3. Update Data
    $siswa->update([
        'nis'           => $request->nis,
        'nama'          => $request->nama,
        'jenis_kelamin' => $request->jenis_kelamin,
        'no_hp'         => $request->no_hp,
        'alamat'        => $request->alamat,
        'tanggal_lahir' => $request->tanggal_lahir,
        'kelas'         => $request->kelas,
    ]);

    $data = $request->all();

    // Jalankan update
    $siswa->update($data);

    return redirect()->back()->with('success', 'Data siswa berhasil diupdate!');
}

    public function destroy($id)
    {
        Siswa::find($id)->delete();
        return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
    }

    public function perKelas(Request $request)
    {
        $kelas = \App\Models\Kelas::all(); 
        $selected_kelas = $request->get('kelas_id');
        $siswa_per_kelas = [];
        
        if ($selected_kelas) {
            // Cari di kolom 'kelas' karena tadi di form input name-nya 'kelas'
            $siswa_per_kelas = \App\Models\Siswa::where('kelas', $selected_kelas)->get();
        }

        return view('admin.menu.siswa-per-kelas', compact('kelas', 'siswa_per_kelas'));
    }

    // === FUNGSI AKTIVASI ===
    public function showAktivasiForm()
    {
        return view('auth.aktivasi_siswa');
    }

    public function prosesAktivasi(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $siswaData = Siswa::where('nis', $request->nis)->first();

        if (!$siswaData) {
            return back()->with('error', 'NIS lo nggak ada di database siswa, Men!');
        }

        User::updateOrCreate(
            ['nisn' => $request->nis], 
            [
                'name' => $siswaData->nama,
                'email' => null,
                'password' => Hash::make($request->password),
                'role' => 'siswa',
            ]
        );

        return redirect()->route('login')->with('success', 'Aktivasi Sukses! Login pake NISN lo.');
    }


    // === FUNGSI DASHBOARD SISWA (DENGAN STATISTIK) ===
    public function dashboardSiswa()
    {
        $user = Auth::user();
        $hariIni = Carbon::now()->toDateString();
        $siswa = Siswa::where('nis', $user->nisn)->first();

        if (!$siswa) {
            return "Data profil lo gak ketemu di tabel siswa, Men!";
        }

        // 1. Ambil status absen hari ini dari tabel Absensi
        $absen = Absensi::where('siswa_id', $siswa->id)
                        ->whereDate('tanggal', $hariIni)
                        ->first();

        // 2. JIKA DI TABEL ABSENSI KOSONG, CEK APAKAH ADA IZIN YANG LAGI PENDING
        // 2. JIKA DI TABEL ABSENSI KOSONG, CEK APAKAH ADA IZIN YANG LAGI PENDING
        if (!$absen) {
            $izinPending = \App\Models\Izin::where('siswa_id', $siswa->id)
                                            ->whereDate('tanggal_mulai', $hariIni)
                                            ->where('status', 'Pending')
                                            ->first();
            
            if ($izinPending) {
                // Ganti baris di bawah ini:
                $absen = (object) [
                    'status' => 'PENDING', // <--- PAKSA JADI TULISAN 'PENDING'
                    'alasan' => 'Sedang diproses admin: ' . $izinPending->jenis_izin, 
                    'jam_masuk' => null,
                    'jam_pulang' => null
                ];
            }
        }

        // Statistik tetap hitung dari tabel Absensi (Hadir, Izin/Sakit yang disetujui, Alpa)
        $hadir = Absensi::where('siswa_id', $siswa->id)->where('status', 'Hadir')->count();
        $izin  = Absensi::where('siswa_id', $siswa->id)->whereIn('status', ['Izin', 'Sakit'])->count();
        $alpa  = Absensi::where('siswa_id', $siswa->id)->where('status', 'Alpa')->count();

        return view('siswa.dashboard', compact('user', 'siswa', 'absen', 'hadir', 'izin', 'alpa'));
    }

    // Fungsi simpan izin tidak masuk
    public function simpanIzin(Request $request)
{
    // 1. Validasi input
    $request->validate([
        'keterangan' => 'required', // Isinya: 'Izin' atau 'Sakit'
        'alasan' => 'required',     // Detail alasannya
    ]);

    // 2. Cari data siswa berdasarkan user yang login
    $siswa = Siswa::where('nis', Auth::user()->nisn)->first();

    if (!$siswa) {
        return back()->with('error', 'Data siswa tidak ditemukan!');
    }

    // 3. SIMPAN KE TABEL 'IZIN' (Bukan tabel Absensi)
    // Ini yang akan membuat data muncul di screenshot halaman admin tadi
    \App\Models\Izin::create([
        'siswa_id'      => $siswa->id,
        'tanggal_mulai' => \Carbon\Carbon::now()->toDateString(),
        'jenis_izin'    => $request->keterangan, // Izin atau Sakit
        'keterangan'    => $request->alasan,
        'status'        => 'Pending',            // Default pending agar admin bisa konfirmasi
    ]);

    return back()->with('success', 'Laporan izin sudah dikirim ke Admin!');
}

    // Fungsi tampilan cetak kartu QR
    public function cetakKartu()
    {
        $user = Auth::user();
        $siswa = Siswa::where('nis', $user->nisn)->first();
        return view('siswa.cetak_kartu', compact('user', 'siswa'));
    }
}