@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-4">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="bi bi-shield-lock-fill text-dark" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="fw-bold">Portal Staf</h3>
                        <p class="text-muted small">Silahkan masuk ke akun petugas anda</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px; font-size: 0.85rem;">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="nisn" class="form-control form-control-lg bg-light @error('nisn') is-invalid @enderror" placeholder="email address" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg bg-light" placeholder="password" required>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 btn-lg shadow-sm" style="border-radius: 12px;">
                            Login Sekarang
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="small mb-1">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-primary">Daftar Petugas</a></p>
                        <a href="/login" class="text-decoration-none text-muted extra-small">Bukan staf? Kembali ke Login Siswa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection