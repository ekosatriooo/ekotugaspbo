@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        {{-- SIDEBAR NAVIGASI (KOLOM KIRI) --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm p-3 mb-3" style="border-radius: 15px;">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="color: inherit;">
                        <div class="me-3">
                            <img src="{{ asset('img/logo-picisan.png') }}" alt="A" width="45" class="rounded-circle">
                        </div>
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-dark fs-5 lh-1">{{ Auth::user()->name }}</span>
                            <small class="text-muted text-capitalize">{{ Auth::user()->role }}</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu shadow border-0 mt-3 w-100" aria-labelledby="dropdownUser" style="border-radius: 12px;">
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2 text-primary"></i> My Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
                <h6 class="fw-bold mb-3 px-2">NAVIGASI UTAMA</h6>
                <div class="list-group list-group-flush">
                    <div class="mb-3">
                        <a href="{{ route('petugas.dashboard') }}" class="list-group-item list-group-item-action border-0 rounded-3 small active text-white bg-primary">
                            <i class="bi bi-house-door me-2"></i> Beranda
                        </a>
                    </div>

                    {{-- CEK AKSES KELOLA ABSENSI --}}
                    @if(Auth::user()->hasPermission('kelola-absensi'))
                    <div class="mb-3">
                        <small class="text-muted fw-bold small px-2">KELOLA ABSENSI</small>
                        <a href="{{ route('absensi.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-clipboard-data me-2"></i> Data Absensi</a>
                        <a href="{{ route('rekap.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-file-earmark-bar-graph me-2"></i> Rekap Absen</a>
                        <a href="{{ route('jam.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-clock me-2"></i> Jam Absen</a>
                    </div>
                    @endif

                    {{-- CEK AKSES SISWA --}}
                    @if(Auth::user()->hasPermission('siswa'))
                    <div class="mb-3">
                        <small class="text-muted fw-bold small px-2">SISWA</small>
                        <a href="{{ route('siswa.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-people me-2"></i> Data Seluruh Siswa</a>
                        <a href="{{ route('siswa.perkelas') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-mortarboard me-2"></i> Siswa per kelas</a>
                        <a href="{{ route('izin.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-envelope-paper me-2"></i> Data izin</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- KONTEN UTAMA (KOLOM KANAN) --}}
        <div class="col-md-9">
            {{-- HEADER JAM DIGITAL --}}
            <div class="card border-0 shadow-sm mb-4 bg-dark text-white" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0" id="clock">00:00:00</h4>
                        <p class="mb-0 opacity-75" id="date-string">Memuat tanggal...</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary px-3 py-2 rounded-pill border border-light">Status: Online</span>
                    </div>
                </div>
            </div>

            {{-- STATS CARDS --}}
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 text-center h-100" style="border-radius: 15px;">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mx-auto mb-3">
                            <i class="bi bi-envelope-check text-warning" style="font-size: 2rem;"></i>
                        </div>
                        <h6 class="text-muted small fw-bold">IZIN PENDING</h6>
                        <h3 class="fw-bold mb-0">{{ $countIzin ?? 0 }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 text-center h-100" style="border-radius: 15px;">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mx-auto mb-3">
                            <i class="bi bi-people-fill text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <h6 class="text-muted small fw-bold">TOTAL SISWA</h6>
                        <h3 class="fw-bold mb-0">{{ $countSiswa ?? 0 }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 text-center h-100" style="border-radius: 15px;">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle d-inline-block mx-auto mb-3">
                            <i class="bi bi-door-open text-danger" style="font-size: 2rem;"></i>
                        </div>
                        <h6 class="text-muted small fw-bold">TOTAL KELAS</h6>
                        <h3 class="fw-bold mb-0">{{ $countKelas ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID');
        document.getElementById('date-string').innerText = now.toLocaleDateString('id-ID', options);
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>

<style>
    .list-group-item { transition: 0.2s; border: none !important; margin-bottom: 2px; }
    .list-group-item:hover { background-color: #f0f2f5 !important; color: #0d6efd !important; transform: translateX(5px); }
    .list-group-item.active { background-color: #0d6efd !important; color: white !important; }
    .dropdown-toggle::after { display: none; }
</style>
@endsection