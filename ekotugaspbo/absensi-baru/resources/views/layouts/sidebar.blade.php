@php
    // Ambil data permissions user yang login untuk filter menu secara real-time
    $userPermissions = DB::table('permissions')
                        ->where('role', Auth::user()->role)
                        ->where('is_accessible', 1)
                        ->pluck('menu_name')
                        ->toArray();

    /**
     * Helper function untuk cek status active berdasarkan Nama Route.
     * Menggunakan wildcard '*' agar menu tetap aktif saat di halaman create/edit.
     */
    function isActive($routeName) {
        return request()->routeIs($routeName) ? 'active text-white bg-primary' : '';
    }
@endphp

{{-- Profile Card --}}
<div class="card border-0 shadow-sm p-3 mb-3" style="border-radius: 15px;">
    <div class="d-flex align-items-center">
        <div class="me-3">
            <img src="{{ asset('img/logo-picisan.png') }}" alt="User" width="45" class="rounded-circle">
        </div>
        <div class="d-flex flex-column">
            <span class="fw-bold text-dark fs-6 lh-1">{{ Auth::user()->name }}</span>
            <small class="text-muted text-capitalize" style="font-size: 0.75rem;">{{ Auth::user()->role }}</small>
        </div>
    </div>
</div>

{{-- Navigation Card --}}
<div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
    <h6 class="fw-bold mb-3 px-2 small text-muted">NAVIGASI UTAMA</h6>
    <div class="list-group list-group-flush">
        
        {{-- Beranda --}}
        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ isActive('admin.dashboard') }}">
            <i class="bi bi-house-door me-2"></i> Beranda
        </a>

        {{-- KELOLA MENU --}}
        @if(in_array('kelola-menu', $userPermissions))
            <div class="mt-3 mb-1 small fw-bold text-muted px-2">KELOLA MENU</div>
            <a href="{{ route('access.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ isActive('access.*') }}">
                <i class="bi bi-layers me-2"></i> Access User
            </a>
        @endif

        {{-- KELOLA ABSENSI --}}
        @if(in_array('kelola-absensi', $userPermissions))
            <div class="mt-3 mb-1 small fw-bold text-muted px-2">KELOLA ABSENSI</div>
            <a href="{{ route('libur.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ isActive('libur.*') }}">
                <i class="bi bi-calendar-x me-2"></i> Atur Libur
            </a>
            <a href="{{ route('absensi.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ isActive('absensi.*') }}">
                <i class="bi bi-clipboard-data me-2"></i> Data Absensi
            </a>
            <a href="{{ route('rekap.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ isActive('rekap.*') }}">
                <i class="bi bi-file-earmark-bar-graph me-2"></i> Rekap Absen
            </a>
            <a href="{{ route('jam.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ isActive('jam.*') }}">
                <i class="bi bi-clock me-2"></i> Jam Absen
            </a>
        @endif

        {{-- SISWA --}}
        @if(in_array('siswa', $userPermissions))
            <div class="mt-3 mb-1 small fw-bold text-muted px-2">SISWA</div>
            <a href="{{ route('siswa.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ isActive('siswa.index') }}">
                <i class="bi bi-people me-2"></i> Data Seluruh Siswa
            </a>
            <a href="{{ route('kelas.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ isActive('kelas.*') }}">
                <i class="bi bi-building me-2"></i> Kelas & Jurusan
            </a>
            <a href="{{ route('siswa.perkelas') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ isActive('siswa.perkelas*') }}">
                <i class="bi bi-mortarboard me-2"></i> Siswa per kelas
            </a>
            <a href="{{ route('izin.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ isActive('izin.*') }}">
                <i class="bi bi-envelope-paper me-2"></i> Data izin
            </a>
        @endif

        {{-- USERS --}}
        @if(in_array('users', $userPermissions))
            <div class="mt-3 mb-1 small fw-bold text-muted px-2">USERS</div>
            <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ isActive('users.*') }}">
                <i class="bi bi-person-gear me-2"></i> Data User
            </a>
        @endif

        {{-- SYSTEM --}}
        @if(in_array('api-config', $userPermissions))
            <div class="mt-3 mb-1 small fw-bold text-muted px-2">SYSTEM</div>
            <a href="{{ route('admin.api.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ isActive('admin.api.*') }}">
                <i class="bi bi-gear-wide-connected me-2"></i> API Config
            </a>
        @endif

        <hr class="text-muted">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="list-group-item list-group-item-action border-0 rounded-3 text-danger w-100 text-start">
                <i class="bi bi-box-arrow-right me-2"></i> Keluar (Logout)
            </button>
        </form>
    </div>
</div>

<style>
    .list-group-item { 
        font-size: 0.875rem; 
        padding: 0.6rem 1rem;
        transition: all 0.2s ease-in-out;
    }
    .list-group-item:hover:not(.active) { 
        background-color: #f8f9fa !important; 
        color: #0d6efd !important; 
        transform: translateX(5px);
    }
    /* Memastikan warna biru menyala saat class .active ada */
    .list-group-item.active { 
        background-color: #0d6efd !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
    }
</style>