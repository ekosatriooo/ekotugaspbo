@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        {{-- SIDEBAR NAVIGASI --}}
        <div class="col-md-3 mb-4">
            @include('layouts.sidebar')
        </div>

        {{-- CONTENT KANAN --}}
        <div class="col-md-9">
            {{-- HEADER CLOCK WIDGET --}}
            <div class="card border-0 shadow-sm mb-4 bg-dark text-white" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0" id="clock">00:00:00</h4>
                        <p class="mb-0 opacity-75" id="date-string">Memuat tanggal...</p>
                    </div>
                    <div class="text-end">
                        <h5 class="fw-bold mb-0">Pengaturan Waktu</h5>
                        <small class="opacity-75 text-info"><i class="bi bi-info-circle me-1"></i> Kelola sesi scan QR</small>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div class="row g-4">
                {{-- SESI MASUK --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-4 me-3">
                                    <i class="bi bi-box-arrow-in-right text-primary fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Sesi Masuk</h5>
                                    <span class="badge bg-soft-primary text-primary px-2" style="font-size: 0.7rem; background-color: #e7f1ff;">PRESENSI PAGI</span>
                                </div>
                            </div>
                            
                            <form action="{{ route('jam.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="tipe" value="masuk">
                                
                                <div class="mb-4">
                                    <label class="small fw-bold text-muted mb-2 d-block">JAM MULAI SCAN</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 bg-light"><i class="bi bi-play-circle text-success"></i></span>
                                        <input type="time" name="mulai" class="form-control form-control-lg border-0 bg-light fw-bold" value="{{ $jamMasuk->mulai ?? '06:00' }}">
                                    </div>
                                    <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">Sistem mulai menerima scan QR.</small>
                                </div>

                                <div class="mb-4">
                                    <label class="small fw-bold text-muted mb-2 d-block">BATAS AKHIR SCAN</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 bg-light"><i class="bi bi-stop-circle text-danger"></i></span>
                                        <input type="time" name="selesai" class="form-control form-control-lg border-0 bg-light fw-bold" value="{{ $jamMasuk->selesai ?? '07:30' }}">
                                    </div>
                                    <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">Setelah jam ini, siswa dianggap Terlambat/Alpa.</small>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm mt-2 transition-btn">
                                    <i class="bi bi-save2 me-2"></i> Simpan Sesi Masuk
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- SESI PULANG --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-success bg-opacity-10 p-3 rounded-4 me-3">
                                    <i class="bi bi-box-arrow-right text-success fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Sesi Pulang</h5>
                                    <span class="badge bg-soft-success text-success px-2" style="font-size: 0.7rem; background-color: #e6ffed;">PRESENSI SORE</span>
                                </div>
                            </div>
                            
                            <form action="{{ route('jam.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="tipe" value="pulang">
                                
                                <div class="mb-4">
                                    <label class="small fw-bold text-muted mb-2 d-block">JAM MULAI PULANG</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 bg-light"><i class="bi bi-door-open text-success"></i></span>
                                        <input type="time" name="mulai" class="form-control form-control-lg border-0 bg-light fw-bold" value="{{ $jamPulang->mulai ?? '14:00' }}">
                                    </div>
                                    <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">Siswa bisa mulai scan untuk absen pulang.</small>
                                </div>

                                <div class="mb-4">
                                    <label class="small fw-bold text-muted mb-2 d-block">BATAS AKHIR PULANG</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 bg-light"><i class="bi bi-clock-history text-danger"></i></span>
                                        <input type="time" name="selesai" class="form-control form-control-lg border-0 bg-light fw-bold" value="{{ $jamPulang->selesai ?? '16:00' }}">
                                    </div>
                                    <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">Batas akhir server menerima data presensi pulang.</small>
                                </div>

                                <button type="submit" class="btn btn-success w-100 py-3 rounded-pill fw-bold shadow-sm mt-2 text-white transition-btn">
                                    <i class="bi bi-save2 me-2"></i> Simpan Sesi Pulang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TIPS CARD --}}
            <div class="card border-0 bg-light mt-4 shadow-none" style="border-radius: 15px;">
                <div class="card-body p-3">
                    <div class="d-flex">
                        <i class="bi bi-lightbulb text-warning fs-4 me-3"></i>
                        <p class="mb-0 small text-muted">
                            <strong>Tips:</strong> Pastikan waktu pada server dan waktu di HP Admin/Siswa sinkron (menggunakan waktu internet otomatis) agar tidak ada kendala saat validasi QR Code.
                        </p>
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
    /* Styling khusus Input Time */
    input[type="time"]::-webkit-calendar-picker-indicator {
        filter: invert(0.5) sepia(1) saturate(5) hue-rotate(175deg);
        cursor: pointer;
    }

    .transition-btn {
        transition: all 0.3s ease;
    }

    .transition-btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
    }

    .input-group-text {
        border-radius: 12px 0 0 12px !important;
    }

    .form-control {
        border-radius: 0 12px 12px 0 !important;
    }

    .form-control:focus {
        background-color: #fff !important;
        border: 1px solid #0d6efd !important;
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.1) !important;
    }
</style>
@endsection