@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        {{-- SIDEBAR AREA --}}
        <div class="col-md-3 mb-4">
            {{-- Mengambil sidebar dari folder layouts --}}
            @include('layouts.sidebar')
        </div>

        {{-- MAIN CONTENT AREA --}}
        <div class="col-md-9">
            
            {{-- WIDGET JAM & TANGGAL --}}
            <div class="card border-0 shadow-sm mb-4 bg-dark text-white" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0" id="clock">00:00:00</h4>
                        <p class="mb-0 opacity-75" id="date-string">Memuat tanggal...</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary px-3 py-2 rounded-pill border border-light">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Status: Online
                        </span>
                    </div>
                </div>
            </div>

            {{-- STATISTIK CARDS --}}
            <div class="row g-3">
                {{-- Card Izin --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 text-center h-100" style="border-radius: 15px;">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mx-auto mb-3">
                            <i class="bi bi-envelope-check text-warning fs-2"></i>
                        </div>
                        <h6 class="text-muted small fw-bold">IZIN PENDING</h6>
                        <h3 class="fw-bold mb-0">{{ $countIzin ?? 0 }}</h3>
                    </div>
                </div>

                {{-- Card Siswa --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 text-center h-100" style="border-radius: 15px;">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mx-auto mb-3">
                            <i class="bi bi-people-fill text-primary fs-2"></i>
                        </div>
                        <h6 class="text-muted small fw-bold">TOTAL SISWA</h6>
                        <h3 class="fw-bold mb-0">{{ $countSiswa ?? 0 }}</h3>
                    </div>
                </div>

                {{-- Card Kelas --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 text-center h-100" style="border-radius: 15px;">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle d-inline-block mx-auto mb-3">
                            <i class="bi bi-door-open text-danger fs-2"></i>
                        </div>
                        <h6 class="text-muted small fw-bold">TOTAL KELAS</h6>
                        <h3 class="fw-bold mb-0">{{ $countKelas ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            {{-- Welcome Message --}}
            <div class="card border-0 shadow-sm mt-4 p-4" style="border-radius: 15px;">
                <h5 class="fw-bold">Selamat Datang, {{ Auth::user()->name }}!</h5>
                <p class="text-muted mb-0">Anda login sebagai <strong>{{ Auth::user()->role }}</strong>. Silakan gunakan menu navigasi untuk mulai mengelola data.</p>
            </div>

        </div>
    </div>
</div>

<script>
    function updateTime() {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        // Menampilkan waktu (WIB)
        document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID');
        // Menampilkan tanggal Indonesia
        document.getElementById('date-string').innerText = now.toLocaleDateString('id-ID', options);
    }
    // Update setiap detik
    setInterval(updateTime, 1000);
    updateTime();
</script>
@endsection