@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        {{-- SIDEBAR NAVIGASI (KOLOM KIRI) --}}
        <div class="col-md-3 mb-4">
            @include('layouts.sidebar')
        </div>

        {{-- KONTEN UTAMA (KOLOM KANAN) --}}
        <div class="col-md-9">
            {{-- WIDGET JAM --}}
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

            {{-- NOTIFIKASI --}}
            @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4 fade show" role="alert" style="border-radius: 12px;">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div><strong>Berhasil!</strong> {{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-4 fade show" role="alert" style="border-radius: 12px;">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div><strong>Gagal!</strong> {{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- FORM CONFIGURATION --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-1"><i class="bi bi-shield-check text-primary me-2"></i>Security Configuration</h5>
                    <p class="text-muted small mb-4">Atur parameter keamanan QR Code dan validasi lokasi presensi.</p>

                    <form action="{{ route('admin.api.update') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            {{-- QR Key --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">QR SECRET KEY</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-key-fill text-warning"></i></span>
                                    <input type="password" name="qr_key" id="qr_key" class="form-control bg-light border-0" value="{{ $settings['qr_key'] ?? 'PICISAN-2025-SECRET' }}" style="border-radius: 0 10px 10px 0;">
                                    <button class="btn btn-outline-light border-0 bg-light text-muted" type="button" onclick="toggleField('qr_key')"><i class="bi bi-eye"></i></button>
                                </div>
                            </div>

                            {{-- Radius --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">RADIUS TOLERANSI (METER)</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt-fill text-danger"></i></span>
                                    <input type="number" name="radius" class="form-control bg-light border-0" value="{{ $settings['radius'] ?? '50' }}" style="border-radius: 0 10px 10px 0;">
                                </div>
                                <small class="text-muted" style="font-size: 0.7rem;">Jarak maksimal siswa dari titik koordinat sekolah.</small>
                            </div>

                            <div class="col-12">
                                <hr class="my-2 opacity-25">
                                <h6 class="fw-bold mb-3"><i class="bi bi-whatsapp text-success me-2"></i>WhatsApp Gateway Setup</h6>
                            </div>

                            {{-- WA Token --}}
                            <div class="col-md-8">
                                <label class="form-label small fw-bold">WA API TOKEN</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-shield-lock-fill text-success"></i></span>
                                    <input type="password" name="wa_token" id="wa_token" class="form-control bg-light border-0" value="{{ $settings['wa_token'] ?? '' }}" placeholder="Masukkan Token API WhatsApp..." style="border-radius: 0 10px 10px 0;">
                                    <button class="btn btn-outline-light border-0 bg-light text-muted" type="button" onclick="toggleField('wa_token')"><i class="bi bi-eye"></i></button>
                                </div>
                                <small class="text-muted" style="font-size: 0.7rem;">Gunakan token dari provider (Fonnte/RuangWA/dll).</small>
                            </div>

                            {{-- WA Number --}}
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">NOMOR SENDER</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-whatsapp text-success"></i></span>
                                    <input type="text" name="wa_number" class="form-control bg-light border-0" value="{{ $settings['wa_number'] ?? '' }}" placeholder="62812345678" style="border-radius: 0 10px 10px 0;">
                                </div>
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill shadow-sm fw-bold">
                                    <i class="bi bi-cloud-arrow-up me-2"></i> Simpan Konfigurasi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update Jam & Tanggal
    function updateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID');
        document.getElementById('date-string').innerText = now.toLocaleDateString('id-ID', options);
    }
    setInterval(updateTime, 1000);
    updateTime();

    // Toggle Visibility untuk password fields
    function toggleField(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = "password";
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }

    // Auto-close Alerts
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 4000);
</script>

<style>
    .input-group-text { border-radius: 10px 0 0 10px; }
    .form-control:focus {
        box-shadow: none;
        background-color: #f8f9fa !important;
        border: 1px solid #0d6efd !important;
    }
</style>
@endsection