@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        {{-- SIDEBAR --}}
        <div class="col-md-3 mb-4">
            @include('layouts.sidebar')
        </div>

        {{-- MAIN CONTENT --}}
        <div class="col-md-9">
            {{-- Clock Header --}}
            <div class="card border-0 shadow-sm mb-4 bg-dark text-white" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0" id="clock">00:00:00</h4>
                        <p class="mb-0 opacity-75" id="date-string">Memuat tanggal...</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary px-3 py-2 rounded-pill border border-light">Database Siswa</span>
                    </div>
                </div>
            </div>

            {{-- Form Tambah Siswa --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-person-plus me-2 text-primary"></i>Tambah Siswa Baru</h5>
                    <form action="{{ route('siswa.store') }}" method="POST" class="row g-3" novalidate>
                        @csrf
                        <div class="col-md-3">
                            <label class="small fw-bold">NIS</label>
                            <input type="text" name="nis" class="form-control rounded-3 @error('nis') is-invalid @enderror" placeholder="NIS" value="{{ old('nis') }}">
                            @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-5">
                            <label class="small fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control rounded-3 @error('nama') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('nama') }}">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-2">
                            <label class="small fw-bold">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select rounded-3 @error('jenis_kelamin') is-invalid @enderror">
                                <option value="" selected disabled>Pilih</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-2">
                            <label class="small fw-bold">Kelas</label>
                            <select name="kelas" class="form-select rounded-3 @error('kelas') is-invalid @enderror">
                                <option value="" disabled selected>Pilih Kelas</option>
                                @foreach(\App\Models\Kelas::all() as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas') == $k->id ? 'selected' : '' }}>{{ $k->kelas }} {{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="small fw-bold">No. HP</label>
                            <input type="text" name="no_hp" class="form-control rounded-3 @error('no_hp') is-invalid @enderror" placeholder="08..." value="{{ old('no_hp') }}">
                            @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="small fw-bold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control rounded-3 @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                            @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold">Alamat</label>
                            <input type="text" name="alamat" class="form-control rounded-3 @error('alamat') is-invalid @enderror" placeholder="Alamat tinggal" value="{{ old('alamat') }}">
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm fw-bold">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel Data Siswa --}}
            <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Daftar Siswa</h5>
                    <div class="position-relative w-50">
                        <span class="position-absolute top-50 start-0 translate-middle-y ps-3">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control rounded-pill ps-5 border-primary-subtle shadow-none" placeholder="Cari NIS atau Nama Siswa">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="siswaTable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th>NIS</th>
                                <th>NAMA SISWA</th>
                                <th>JENIS KELAMIN</th>
                                <th>KELAS</th>
                                <th>NO. HP</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa as $s)
                            <tr>
                                <td class="small fw-bold">{{ $s->nis }}</td>
                                <td>
                                    <span class="fw-bold d-block">{{ $s->nama }}</span>
                                    <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $s->alamat ?? 'Belum diisi' }}</small>
                                </td>
                                <td><span class="badge {{ $s->jenis_kelamin == 'L' ? 'bg-info text-info' : 'bg-danger text-danger' }} bg-opacity-10">{{ $s->jenis_kelamin }}</span></td>
                                <td>
                                    @if($s->kelasRelasi)
                                        <span class="badge bg-dark bg-opacity-10 text-dark border-0">
                                            {{ $s->kelasRelasi->kelas }} {{ $s->kelasRelasi->nama_kelas }}
                                        </span>
                                    @else
                                        <span class="text-danger small italic">N/A</span>
                                    @endif
                                </td>
                                <td class="small">{{ $s->no_hp ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-light btn-sm rounded-circle text-primary border shadow-sm" data-bs-toggle="modal" data-bs-target="#editSiswa{{ $s->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" id="delete-form-{{ $s->id }}">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-light btn-sm rounded-circle text-danger border shadow-sm" onclick="confirmDelete({{ $s->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            {{-- Include Edit Modal --}}
                            @include('admin.siswa.partials.modal-edit', ['s' => $s])
                            @empty
                            <tr id="emptyRow">
                                <td colspan="6" class="text-center py-5 text-muted">Belum ada data siswa.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus { box-shadow: none; border-color: #0d6efd; }
    .table thead th { font-weight: 600; letter-spacing: 0.5px; border-top: none; }
</style>

<script>
    // Update Jam
    function updateTime() {
        const now = new Date();
        document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID');
        document.getElementById('date-string').innerText = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    }
    setInterval(updateTime, 1000);
    updateTime();

    // Live Search
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#siswaTable tbody tr:not(#emptyRow)');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

    // SweetAlert Notif
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
    @endif

    // Confirm Delete
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus data ini?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection