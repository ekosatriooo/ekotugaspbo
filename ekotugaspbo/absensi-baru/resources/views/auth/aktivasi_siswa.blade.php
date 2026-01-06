@extends('layouts.app')

@section('content')
<div class="container-fluid" style="min-height: 80vh; display: flex; align-items: center; background: #f4f7fe;">
    <div class="row justify-content-center w-100">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-lg p-4" style="border-radius: 25px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 d-inline-block p-3 rounded-circle mb-3">
                        <i class="bi bi-shield-lock-fill text-primary fs-2"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">Aktivasi Akun</h3>
                    <p class="text-muted small">Khusus Siswa Baru / Belum Aktif</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm small rounded-3 mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('siswa.aktivasi.proses') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">NISN</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light"><i class="bi bi-person-vcard text-muted"></i></span>
                            <input type="text" name="nis" class="form-control form-control-lg border-0 bg-light fs-6" placeholder="NISN" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">Buat Password</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light"><i class="bi bi-key text-muted"></i></span>
                            <input type="password" name="password" class="form-control form-control-lg border-0 bg-light fs-6" placeholder="Min. 6 Karakter" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="small fw-bold text-muted mb-2">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light"><i class="bi bi-check2-circle text-muted"></i></span>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg border-0 bg-light fs-6" placeholder="Samakan passwordnya" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm mb-3">
                        <i class="bi bi-rocket-takeoff-fill me-2"></i> Aktifkan Akun Sekarang
                    </button>
                    
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none small text-muted">
                            Sudah aktif? <span class="text-primary fw-bold">Login Disini</span>
                        </a>
                    </div>
                </form>
            </div>
            
            <p class="text-center text-muted mt-4 small">
                &copy; 2024 - Absensi Picisan Version
            </p>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.1) !important;
        border: 1px solid #0d6efd !important;
    }
    .input-group-text {
        border-top-left-radius: 12px !important;
        border-bottom-left-radius: 12px !important;
    }
    .form-control {
        border-top-right-radius: 12px !important;
        border-bottom-right-radius: 12px !important;
    }
    .btn-primary {
        background: linear-gradient(45deg, #0d6efd, #004dc7);
        transition: 0.3s;
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(13, 110, 253, 0.3) !important;
    }
</style>
@endsection