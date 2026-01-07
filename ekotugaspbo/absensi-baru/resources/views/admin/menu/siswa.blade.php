@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        {{-- SIDEBAR --}}
        <div class="col-md-3 mb-4">
            {{-- Bagian ini akan merender Sidebar yang Anda berikan sebelumnya --}}
            @include('layouts.sidebar')
        </div>

        {{-- MAIN CONTENT --}}
        <div class="col-md-9">
            {{-- Header Jam & Status --}}
            <div class="card border-0 shadow-sm mb-4 bg-dark text-white" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0" id="clock">00:00:00</h4>
                        <p class="mb-0 opacity-75" id="date-string">Memuat tanggal...</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary px-3 py-2 rounded-pill border border-light border-opacity-25">Database Siswa</span>
                    </div>
                </div>
            </div>

            {{-- Form Tambah Siswa --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-person-plus-fill me-2 text-primary"></i>Tambah Siswa Baru</h5>
                    <form action="{{ route('siswa.store') }}" method="POST" class="row g-3">
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
                            <label class="small fw-bold">Gender</label>
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
                                <option value="" disabled selected>Pilih</option>
                                @foreach(\App\Models\Kelas::all() as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas') == $k->id ? 'selected' : '' }}>{{ $k->kelas }} {{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-3">
                            <label class="small fw-bold">No. HP (WhatsApp)</label>
                            <input type="text" name="no_hp" class="form-control rounded-3 @error('no_hp') is-invalid @enderror" placeholder="628..." value="{{ old('no_hp') }}">
                            @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="small fw-bold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control rounded-3 @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                            @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold">Alamat</label>
                            <input type="text" name="alamat" class="form-control rounded-3 @error('alamat') is-invalid @enderror" placeholder="Alamat rumah" value="{{ old('alamat') }}">
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12 text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm fw-bold">
                                <i class="bi bi-save me-1"></i> Simpan Data Siswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel Data Siswa --}}
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0 text-dark">Daftar Seluruh Siswa</h5>
                        <div class="position-relative w-50">
                            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control rounded-pill ps-5 border-0 bg-light shadow-none" placeholder="Cari berdasarkan NIS atau Nama...">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="siswaTable">
                            <thead class="bg-light text-muted small">
                                <tr>
                                    <th class="ps-3">NIS</th>
                                    <th>INFO SISWA</th>
                                    <th>KONTAK & TGL LAHIR</th>
                                    <th>KELAS</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa as $s)
                                <tr>
                                    <td class="ps-3 fw-bold text-dark small">{{ $s->nis }}</td>
                                    <td>
                                        <div class="fw-bold text-dark text-uppercase">{{ $s->nama }}</div>
                                        <div class="small text-muted text-truncate" style="max-width: 200px;">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $s->alamat ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small fw-bold text-dark"><i class="bi bi-whatsapp text-success me-1"></i>{{ $s->no_hp ?? '-' }}</div>
                                        <div class="small text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->format('d/m/Y') : '-' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border-0 px-3 py-2">
                                            {{ $s->kelasRelasi->kelas ?? '?' }} {{ $s->kelasRelasi->nama_kelas ?? '?' }}
                                        </span>
                                    </td>
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

                                {{-- MODAL EDIT (DITULIS LANGSUNG) --}}
                                <div class="modal fade" id="editSiswa{{ $s->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                            <div class="modal-header border-0 p-4 pb-0">
                                                <h5 class="fw-bold mb-0 text-dark">Update Data Siswa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('siswa.update', $s->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body p-4">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="small fw-bold mb-1">NIS</label>
                                                            <input type="text" name="nis" class="form-control rounded-3" value="{{ $s->nis }}">
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label class="small fw-bold mb-1">Nama Lengkap</label>
                                                            <input type="text" name="nama" class="form-control rounded-3" value="{{ $s->nama }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="small fw-bold mb-1">Jenis Kelamin</label>
                                                            <select name="jenis_kelamin" class="form-select rounded-3">
                                                                <option value="L" {{ $s->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                                <option value="P" {{ $s->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="small fw-bold mb-1">Kelas</label>
                                                            <select name="kelas" class="form-select rounded-3">
                                                                @foreach(\App\Models\Kelas::all() as $k)
                                                                    <option value="{{ $k->id }}" {{ $s->kelas == $k->id ? 'selected' : '' }}>{{ $k->kelas }} {{ $k->nama_kelas }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="small fw-bold mb-1">Tanggal Lahir</label>
                                                            <input type="date" name="tanggal_lahir" class="form-control rounded-3" value="{{ $s->tanggal_lahir }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="small fw-bold mb-1">No. HP (WhatsApp)</label>
                                                            <input type="text" name="no_hp" class="form-control rounded-3" value="{{ $s->no_hp }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="small fw-bold mb-1">Alamat</label>
                                                            <input type="text" name="alamat" class="form-control rounded-3" value="{{ $s->alamat }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 p-4 pt-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted small italic">Tidak ada data siswa ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function updateTime() {
        const now = new Date();
        document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID');
        document.getElementById('date-string').innerText = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    }
    setInterval(updateTime, 1000);
    updateTime();

    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#siswaTable tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus data siswa?',
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

    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
    @endif
</script>

<style>
    .form-control:focus, .form-select:focus { box-shadow: none !important; border-color: #0d6efd !important; }
    .table thead th { font-weight: 700; font-size: 11px; letter-spacing: 1px; border-top: none; text-transform: uppercase; }
    .btn-light:hover { background-color: #e9ecef; }
</style>

@if(session('edit_id'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('editSiswa{{ session('edit_id') }}');
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
});
</script>
@endif
@endsection