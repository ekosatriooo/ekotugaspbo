@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Hallo, Silahkan Login</h3>
                        <p class="text-muted small">Gunakan NISN dan Password untuk masuk</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">NISN</label>
                            <input type="text" name="nisn" class="form-control form-control-lg bg-light" placeholder="Masukkan NISN anda" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg bg-light" placeholder="Masukkan password" required>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 btn-lg shadow-sm mb-3" style="border-radius: 12px;">
                            Login Siswa
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="small mb-1">Belum punya password? <a href="/aktivasi-siswa" class="text-decoration-none fw-bold text-primary">Klik disini</a></p>
                        <small class="text-muted d-block mb-4">Khusus siswa yang sudah terdaftar NISN-nya</small>

                        <div class="d-grid gap-2">
                            <a href="/scan-absen" class="btn btn-success btn-md fw-bold shadow-sm" style="border-radius: 10px;">
                                <i class="bi bi-qr-code-scan"></i> Link Absen (QR Scanner)
                            </a>
                            <a href="/login-admin" class="btn btn-outline-dark btn-sm shadow-sm" style="border-radius: 10px;">
                                Login sebagai Admin / Staf
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection