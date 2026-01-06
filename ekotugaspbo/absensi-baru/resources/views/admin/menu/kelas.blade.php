@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        {{-- SIDEBAR --}}
        <div class="col-md-3 mb-4">
            @include('layouts.sidebar') {{-- Asumsi sidebar sudah dipisah agar rapi --}}
        </div>

        {{-- MAIN CONTENT --}}
        <div class="col-md-9">
            {{-- HEADER CLOCK --}}
            <div class="card border-0 shadow-sm mb-4 bg-dark text-white" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0" id="clock">00:00:00</h4>
                        <p class="mb-0 opacity-75" id="date-string">Memuat tanggal...</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary px-3 py-2 rounded-pill border border-light"><i class="bi bi-building me-1"></i> Manajemen Kelas</span>
                    </div>
                </div>
            </div>

            {{-- FORM TAMBAH KELAS --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Kelas Baru</h5>
                    <form action="{{ route('kelas.store') }}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-md-2">
                            <label class="small fw-bold text-muted">TINGKAT</label>
                            <select name="kelas" class="form-select border-0 bg-light @error('kelas') is-invalid @enderror" required>
                                <option value="" selected disabled>Pilih...</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="small fw-bold text-muted">NAMA KELAS</label>
                            <input type="text" name="nama_kelas" 
                                class="form-control border-0 bg-light @error('nama_kelas') is-invalid @enderror" 
                                placeholder="Contoh: RPL 1" value="{{ old('nama_kelas') }}" required>
                        </div>
                        <div class="col-md-5">
                            <label class="small fw-bold text-muted">JURUSAN</label>
                            <input type="text" name="jurusan" class="form-control border-0 bg-light" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABEL DATA --}}
            <div class="card border-0 shadow-sm p-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">Daftar Kelas & Jurusan</h5>
                    <p class="text-muted small">Total kelas terdaftar: {{ $kelas->count() }}</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="text-muted small">
                                <th class="ps-4">ID</th>
                                <th>KELAS</th>
                                <th>NAMA KELAS</th>
                                <th>JURUSAN</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kelas as $k)
                            <tr>
                                <td class="ps-4 small fw-bold text-muted">#{{ $k->id }}</td>
                                <td><span class="badge bg-secondary px-2 py-1 small">{{ $k->kelas }}</span></td>
                                <td><span class="bg-primary bg-opacity-10 text-primary rounded px-3 py-2 fw-bold small">{{ $k->nama_kelas }}</span></td>
                                <td class="small text-muted">{{ $k->jurusan }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Edit --}}
                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm" data-bs-toggle="modal" data-bs-target="#editKelas{{ $k->id }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        {{-- Hapus --}}
                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" onclick="confirmDelete({{ $k->id }})">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>

                                        <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" id="delete-form-{{ $k->id }}" class="d-none">
                                            @csrf @method('DELETE')
                                        </form>

                                        {{-- MODAL EDIT --}}
                                        <div class="modal fade" id="editKelas{{ $k->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content text-dark text-start border-0 shadow" style="border-radius: 20px;">
                                                    <div class="modal-header border-0 p-4 pb-0">
                                                        <h5 class="fw-bold"><i class="bi bi-pencil-square me-2 text-primary"></i>Update Data Kelas</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('kelas.update', $k->id) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <div class="modal-body p-4">
                                                            <div class="mb-3">
                                                                <label class="small fw-bold mb-2">Tingkat Kelas</label>
                                                                <select name="kelas" class="form-select bg-light border-0" required>
                                                                    <option value="X" {{ $k->kelas == 'X' ? 'selected' : '' }}>X</option>
                                                                    <option value="XI" {{ $k->kelas == 'XI' ? 'selected' : '' }}>XI</option>
                                                                    <option value="XII" {{ $k->kelas == 'XII' ? 'selected' : '' }}>XII</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="small fw-bold mb-2">Nama Kelas</label>
                                                                <input type="text" name="nama_kelas" class="form-control bg-light border-0" value="{{ $k->nama_kelas }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="small fw-bold mb-2">Jurusan</label>
                                                                <input type="text" name="jurusan" class="form-control bg-light border-0" value="{{ $k->jurusan }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 p-4 pt-0">
                                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <img src="https://illustrations.popsy.co/gray/box.svg" alt="empty" width="100" class="mb-3">
                                    <p class="text-muted">Wah, belum ada data kelas nih bosku.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function updateTime() {
        const now = new Date();
        document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID');
        document.getElementById('date-string').innerText = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    }
    setInterval(updateTime, 1000);
    updateTime();

    // Notifikasi SweetAlert
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Mantap!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000,
            background: '#ffffff',
            iconColor: '#0d6efd'
        });
    @endif

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Kelas?',
            text: "Siswa di kelas ini mungkin akan kehilangan data relasinya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            border: 'none',
            borderRadius: '15px'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

<style>
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        border: 1px solid #0d6efd !important;
    }
    .table thead th {
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-outline-primary:hover, .btn-outline-danger:hover {
        color: white;
    }
</style>
@endsection