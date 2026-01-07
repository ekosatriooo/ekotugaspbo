<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\JamAbsenController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\IzinController;
use App\Models\Menu;


Route::get('/', function () {
    return redirect('/login');
});

Route::get('/aktivasi-siswa', [App\Http\Controllers\SiswaController::class, 'showAktivasiForm'])->name('siswa.aktivasi');
Route::post('/aktivasi-siswa', [App\Http\Controllers\SiswaController::class, 'prosesAktivasi'])->name('siswa.aktivasi.proses');

Route::get('/scan-absen', [App\Http\Controllers\AbsensiController::class, 'scanPage'])->name('scan.index');
Route::post('/proses-scan', [App\Http\Controllers\AbsensiController::class, 'prosesScan'])->name('proses.scan');

// Halaman login khusus admin/staf
Route::get('/login-admin', function () {
    return view('auth.login_admin');
});


Auth::routes();

// 3. Route Setelah Login
// 3. Route Setelah Login
Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ============================================================
    // ROUTE YANG BISA DIAKSES ADMIN & PETUGAS (Pake role:admin,petugas)
    // ============================================================
    Route::middleware(['role:admin,petugas,guru'])->group(function () {
        
        // Dashboard masing-masing (tetap dipisah foldernya)
        Route::get('/admin/dashboard', [UserController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/petugas/dashboard', [UserController::class, 'petugasDashboard'])->name('petugas.dashboard');
        Route::get('/guru/dashboard', [UserController::class, 'guruDashboard'])->name('guru.dashboard');

        // Manajemen Siswa
        Route::get('/admin/siswa', [SiswaController::class, 'index'])->name('siswa.index');
        Route::post('/admin/siswa', [SiswaController::class, 'store'])->name('siswa.store');
        Route::put('/admin/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('/admin/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
        Route::get('/admin/siswa-per-kelas', [SiswaController::class, 'perKelas'])->name('siswa.perkelas');

        // Kelas
        Route::get('/admin/kelas', [KelasController::class, 'index'])->name('kelas.index');
        Route::post('/admin/kelas', [KelasController::class, 'store'])->name('kelas.store');
        Route::put('/admin/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update');
        Route::delete('/admin/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

        // Atur Libur
        Route::get('/admin/atur-libur', [HolidayController::class, 'index'])->name('libur.index');
        Route::post('/admin/atur-libur', [HolidayController::class, 'store'])->name('libur.store');
        Route::delete('/admin/atur-libur/{id}', [HolidayController::class, 'destroy'])->name('libur.destroy');

        // Data Absensi
        Route::get('/admin/data-absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::post('/admin/generate-alpa', [AbsensiController::class, 'generateAlpa'])->name('absensi.generateAlpa');
        Route::patch('/absensi/{id}/status', [AbsensiController::class, 'updateStatus'])->name('absensi.updateStatus');
        Route::delete('/absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');
        
        // Rekap & Jam Absen
        Route::get('/admin/rekap_absensi', [RekapController::class, 'index'])->name('rekap.index');
        Route::get('/admin/rekap_absensi/pdf/{bulan}/{tahun}', [RekapController::class, 'cetakPdf'])->name('rekap.pdf');
        Route::get('/admin/jam-absen', [JamAbsenController::class, 'index'])->name('jam.index');
        Route::post('/admin/jam-absen/update', [JamAbsenController::class, 'update'])->name('jam.update');

        // Izin
        Route::get('/admin/izin', [IzinController::class, 'index'])->name('izin.index');
        Route::post('/admin/izin/setujui/{id}', [IzinController::class, 'setujui'])->name('izin.setujui');
        Route::post('/admin/izin/tolak/{id}', [IzinController::class, 'tolak'])->name('izin.tolak');
    });

    // ============================================================
    // KHUSUS ADMIN SAJA (Menu yang gak boleh disentuh petugas)
    // ============================================================
    Route::middleware(['role:admin'])->group(function () {
        // Access Menu / Permissions
        Route::get('/admin/access-menu', function () {
            $menus = \App\Models\Menu::all(); 
            return view('admin.menu.access', compact('menus'));
        })->name('access.index');

        Route::post('/admin/update-permission', [UserController::class, 'updatePermission'])->name('permission.update');

        // User Management
        Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
        Route::put('/admin/users/{id}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');

        // API Config
        Route::get('/admin/api-config', [AbsensiController::class, 'apiConfig'])->name('admin.api.index');
        Route::post('/admin/api-config/update', [AbsensiController::class, 'apiUpdate'])->name('admin.api.update');
    });


    Route::middleware(['role:siswa'])->group(function () {
        // Halaman Utama Dashboard
        Route::get('/siswa/dashboard', [SiswaController::class, 'dashboardSiswa'])->name('siswa.dashboard');
        
        // Fitur Izin (Post Data)
        Route::post('/siswa/izin', [SiswaController::class, 'simpanIzin'])->name('siswa.izin');
        
        // Fitur Cetak Kartu QR
        Route::get('/siswa/cetak-kartu', [SiswaController::class, 'cetakKartu'])->name('siswa.cetak');
    });
});