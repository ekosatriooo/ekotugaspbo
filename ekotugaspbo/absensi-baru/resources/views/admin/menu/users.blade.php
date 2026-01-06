@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm p-3 mb-3" style="border-radius: 15px;">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="color: inherit;">
                        <div class="me-3">
                            <img src="{{ asset('img/logo-picisan.png') }}" alt="A" width="45" class="rounded-circle">
                        </div>
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-dark fs-5 lh-1">{{ Auth::user()->name }}</span>
                            <small class="text-muted">Administrator</small>
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
                        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action border-0 rounded-3 small {{ request()->is('admin/dashboard') ? 'active text-white bg-primary' : '' }}">
                            <i class="bi bi-house-door me-2"></i> Beranda
                        </a>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted fw-bold small px-2">KELOLA MENU</small>
                        <a href="{{ route('access.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small {{ request()->is('admin/access-menu') ? 'active text-white bg-primary' : '' }}">
                            <i class="bi bi-layers me-2"></i> Access User
                        </a>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted fw-bold small px-2">KELOLA ABSENSI</small>
                        <a href="{{ route('libur.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-calendar-x me-2"></i> Atur Libur</a>
                        <a href="{{ route('absensi.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-clipboard-data me-2"></i> Data Absensi</a>
                        <a href="{{ route('rekap.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-file-earmark-bar-graph me-2"></i> Rekap Absen</a>
                        <a href="{{ route('jam.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-clock me-2"></i> Jam Absen</a>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted fw-bold small px-2">SISWA</small>
                        <a href="{{ route('siswa.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-people me-2"></i> Data Seluruh Siswa</a>
                        <a href="{{ route('kelas.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-building me-2"></i> Kelas & Jurusan</a>
                        <a href="{{ route('siswa.perkelas') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-mortarboard me-2"></i> Siswa per kelas</a>
                        <a href="{{ route('izin.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-envelope-paper me-2"></i> Data izin</a>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted fw-bold small px-2">USERS</small>
                        <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small active text-white bg-primary"><i class="bi bi-person-gear me-2"></i> Data User</a>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted fw-bold small px-2">SYSTEM</small>
                        <a href="{{ route('admin.api.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 small"><i class="bi bi-gear-wide-connected me-2"></i> API Config</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
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

            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Daftar Pengguna Sistem</h5>
                    <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                        <i class="bi bi-plus-circle me-1"></i> Tambah User
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4 py-3">Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    </td>
                                    <td class="text-muted small">{{ $user->email }}</td>
                                    <td>
                                        @if($user->role == 'admin')
                                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 rounded-pill">ADMIN</span>
                                        @elseif($user->role == 'petugas')
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 rounded-pill">PETUGAS</span>
                                        @else
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 rounded-pill">GURU</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-light text-primary rounded-3" data-bs-toggle="modal" data-bs-target="#editRole{{ $user->id }}">
                                            <i class="bi bi-pencil-square me-1"></i> Ubah Role
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="editRole{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                            <div class="modal-body p-4 text-center">
                                                <h6 class="fw-bold mb-3">Ubah Role: {{ $user->name }}</h6>
                                                <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <select name="role" class="form-select mb-3 rounded-3">
                                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                                        <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                                                    </select>
                                                    <div class="d-grid gap-2">
                                                        <button type="submit" class="btn btn-primary rounded-3">Simpan Perubahan</button>
                                                        <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
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
    .badge { font-weight: 600; letter-spacing: 0.5px; }
</style>
@endsection