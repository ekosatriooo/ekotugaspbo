@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="bi bi-person-plus-fill text-dark" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="fw-bold">Daftar Akun Petugas</h3>
                        <p class="text-muted small">Lengkapi data untuk akses sistem staf</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Username</label>
                            <input type="text" name="name" class="form-control form-control-lg bg-light @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="username">
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="email address">
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg bg-light @error('password') is-invalid @enderror" placeholder="password" required>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg bg-light" placeholder="ulangi password" required>
                            @error('password')
                                @if(str_contains($message, 'confirmation') || str_contains($message, 'konfirmasi'))
                                    <div class="text-danger small mt-1">Konfirmasi password tidak cocok.</div>
                                @endif
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-dark w-100 btn-lg shadow-sm" style="border-radius: 12px;">
                            Buat Akun Sekarang
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="small">Sudah punya akun? <a href="/login-admin" class="text-decoration-none fw-bold text-primary">Login Disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection