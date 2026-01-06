<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\JamAbsen;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Setting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AbsensiController extends Controller
{
    /**
     * Menampilkan daftar absensi di halaman Admin dengan Filter Tanggal & Kelas
     */
    /**
     * Menampilkan daftar absensi di halaman Admin dengan Filter Tanggal & Kelas
     */
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::now()->format('Y-m-d'));
        
        // 1. Ambil input filter kelas (ID Kelas)
        $kelas_id = $request->input('kelas_id'); 

        $daftar_kelas = \App\Models\Kelas::orderBy('kelas', 'asc')->orderBy('nama_kelas', 'asc')->get(); 

        // PERBAIKAN: Gunakan Eager Loading ['siswa.kelas_relasi'] 
        // agar data nama kelas ikut terambil dari database
        $query = Absensi::with(['siswa.kelasRelasi'])
            ->whereDate('tanggal', $tanggal);

        // 3. Logika Filter: Filter berdasarkan kelas_id dari tabel siswa
        if ($kelas_id) {
            $query->whereHas('siswa', function($q) use ($kelas_id) {
                // Kolom 'kelas' di tabel siswa menyimpan ID dari tabel Kelas
                $q->where('kelas', $kelas_id); 
            });
        }

        $absensi = $query->orderBy('created_at', 'desc')->get();

        // 4. Kirim variabel ke view
        return view('admin.menu.absensi', compact('absensi', 'tanggal', 'daftar_kelas'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Terlambat,Izin,Sakit,Alpa'
        ]);

        try {
            $absensi = Absensi::findOrFail($id);
            $absensi->update([
                'status' => $request->status
            ]);

            return back()->with('success', 'Status absensi berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui status!');
        }
    }

    /**
     * Menghapus data absensi
     */
    public function destroy($id)
    {
        try {
            $absensi = Absensi::findOrFail($id);
            $absensi->delete();

            return back()->with('success', 'Data absensi berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data!');
        }
    }

    /**
     * Halaman Scan QR untuk Siswa
     */
    public function scanPage()
    {
        $jamMasuk = JamAbsen::where('tipe', 'masuk')->first();
        $jamPulang = JamAbsen::where('tipe', 'pulang')->first();

        return view('siswa.scan', compact('jamMasuk', 'jamPulang'));
    }

    /**
     * Proses Scan QR Code
     */
    public function prosesScan(Request $request)
    {
        try {
            // 1. Validasi Security Key
            $dbSecretKey = Setting::where('key', 'qr_key')->first()->value ?? 'PICISAN-2025-SECRET';
            $scannedData = explode('|', $request->qr_code);
            
            if (count($scannedData) < 2) {
                return response()->json(['status' => 'error', 'message' => 'Format QR tidak valid!']);
            }

            $nis = $scannedData[0];
            $clientSecret = $scannedData[1];

            if ($clientSecret !== $dbSecretKey) {
                return response()->json(['status' => 'error', 'message' => 'Security Key ditolak!']);
            }

            // 2. Inisialisasi Waktu
            $now = Carbon::now();
            $jamSekarang = $now->format('H:i:s');
            $hariIni = $now->format('Y-m-d');

            $siswa = Siswa::where('nis', $nis)->first();
            if (!$siswa) {
                return response()->json(['status' => 'error', 'message' => 'Siswa tidak ditemukan!']);
            }

            $configMasuk = JamAbsen::where('tipe', 'masuk')->first();
            $configPulang = JamAbsen::where('tipe', 'pulang')->first();

            if (!$configMasuk || !$configPulang) {
                return response()->json(['status' => 'error', 'message' => 'Konfigurasi jam absen belum diatur admin!']);
            }
            
            $cekAbsen = Absensi::where('siswa_id', $siswa->id)->whereDate('tanggal', $hariIni)->first();

            // --- LOGIC ABSEN MASUK ---
            // Tentukan Batas Toleransi Terlambat (Batas Akhir Scan + 15 Menit)
            $toleransiTerlambat = Carbon::parse($configMasuk->selesai)->addMinutes(15)->format('H:i:s');

            // Cek apakah waktu sekarang masih dalam rentang (Mulai Scan s/d Toleransi Terlambat)
            if ($jamSekarang >= $configMasuk->mulai && $jamSekarang <= $toleransiTerlambat) {
                
                if ($cekAbsen) {
                    return response()->json(['status' => 'warning', 'message' => "Siswa atas nama $siswa->nama sudah melakukan presensi masuk."]);
                }

                // PENENTUAN STATUS:
                // Jika jam sekarang melewati Batas Akhir Scan ($configMasuk->selesai), maka Terlambat
                if ($jamSekarang > $configMasuk->selesai) {
                    $status = 'Terlambat';
                    $msgPagi = "Anda terlambat, segera menuju kelas!";
                } else {
                    $status = 'Hadir';
                    $msgPagi = "Selamat belajar!";
                }

                Absensi::create([
                    'siswa_id' => $siswa->id,
                    'tanggal' => $hariIni,
                    'jam_masuk' => $jamSekarang,
                    'status' => $status,
                ]);

                $pesanMasuk = "📢 *ABSENSI MASUK*\n\nNama: *$siswa->nama*\nJam: $jamSekarang\nStatus: *$status*\n\nBerhasil dicatat oleh sistem.";
                $this->sendWhatsapp($siswa->no_hp, $pesanMasuk);

                return response()->json([
                    'status' => 'success', 
                    'message' => "Presensi Berhasil. $msgPagi ($status)"
                ]);
            }

            // --- LOGIC ABSEN PULANG ---
            if ($jamSekarang >= $configPulang->mulai && $jamSekarang <= $configPulang->selesai) {
                if (!$cekAbsen) {
                    return response()->json(['status' => 'error', 'message' => 'Anda tidak memiliki data absen masuk hari ini!']);
                }

                if ($cekAbsen->jam_pulang != null) {
                    return response()->json(['status' => 'warning', 'message' => "Anda sudah absen pulang sebelumnya."]);
                }

                $cekAbsen->update(['jam_pulang' => $jamSekarang]);

                $pesanPulang = "📢 *ABSENSI PULANG*\n\nNama: *$siswa->nama*\nJam Pulang: $jamSekarang\n\nHati-hati di jalan.";
                $this->sendWhatsapp($siswa->no_hp, $pesanPulang);

                return response()->json([
                    'status' => 'success', 
                    'message' => "Presensi pulang berhasil tercatat. Hati-hati di jalan, $siswa->nama!"
                ]);
            }

            // Jika diluar rentang waktu masuk (termasuk toleransi) dan diluar rentang pulang
            return response()->json(['status' => 'error', 'message' => 'Bukan sesi absensi atau sudah ditutup (Melewati batas toleransi).']);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Sistem Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Konfigurasi API Settings
     */
    public function apiConfig()
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.menu.api', compact('settings'));
    }

    public function apiUpdate(Request $request)
    {
        $request->validate([
            'qr_key'   => 'required|string',
            'radius'   => 'required|numeric',
            'wa_token' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();
            foreach ($request->except('_token') as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
            DB::commit();
            return back()->with('success', 'Konfigurasi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui konfigurasi!');
        }
    }

    /**
     * Fitur WhatsApp (Fonnte)
     */
    private function sendWhatsapp($target, $message)
    {
        $token = Setting::where('key', 'wa_token')->first()->value ?? null;
        if (!$token || !$target) return false;

        try {
            Http::withHeaders(['Authorization' => $token])
                ->post('https://api.fonnte.com/send', [
                    'target' => $target,
                    'message' => $message,
                    'countryCode' => '62'
                ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Tutup Absen: Set Siswa yang tidak scan menjadi "Alpa"
     */
    public function generateAlpa(Request $request)
    {
        $tanggal = $request->input('tanggal', date('Y-m-d'));
    
    // Ambil semua ID siswa
    $semuaSiswa = Siswa::pluck('id');
    
    // Ambil ID siswa yang SUDAH ada di tabel absensi (baik hadir, izin, atau alpa)
    $sudahPunyaStatus = Absensi::whereDate('tanggal', $tanggal)->pluck('siswa_id');
    
    // Hanya ambil siswa yang benar-benar belum punya record sama sekali hari ini
    $yangBelumAbsen = $semuaSiswa->diff($sudahPunyaStatus);

    if ($yangBelumAbsen->isEmpty()) {
        return back()->with('info', 'Semua siswa sudah memiliki status absensi hari ini.');
    }

        $dataInsert = [];
        foreach ($yangBelumAbsen as $idSiswa) {
            $dataInsert[] = [
                'siswa_id'   => $idSiswa,
                'tanggal'    => $tanggal,
                'status'     => 'Alpa',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        Absensi::insert($dataInsert);

        return back()->with('success', count($dataInsert) . ' siswa otomatis diset Alpa!');
    }
}