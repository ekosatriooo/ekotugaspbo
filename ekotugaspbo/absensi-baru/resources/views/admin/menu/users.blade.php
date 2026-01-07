@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        {{-- SIDEBAR COLUMN --}}
        <div class="col-md-3 mb-4">
            @include('layouts.sidebar')
        </div>

        {{-- MAIN CONTENT COLUMN --}}
        <div class="col-md-9">
            {{-- Header Card --}}
            <div class="card border-0 shadow-sm mb-4 bg-dark text-white" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0" id="clock">00:00:00</h4>
                        <p class="mb-0 opacity-75" id="date-string">Memuat tanggal...</p>
                    </div>
                    <div class="text-end text-white">
                        <h5 class="fw-bold mb-0">Manajemen User</h5>
                        <small class="opacity-75">Kelola Hak Akses Petugas & Guru</small>
                    </div>
                </div>
            </div>

            {{-- Table Card dsb... (Lanjutkan kode tabel user kamu di sini) --}}
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                {{-- Isi tabel user --}}
            </div>
        </div>
    </div>
</div>

<script>
    // Script jam tetap di sini karena spesifik untuk ID clock di halaman ini
    function updateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID');
        document.getElementById('date-string').innerText = now.toLocaleDateString('id-ID', options);
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>
@endsection