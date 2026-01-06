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
            {{-- Header (Clock & Status) --}}
            <div class="card border-0 shadow-sm mb-4 bg-dark text-white" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0" id="clock">00:00:00</h4>
                        <p class="mb-0 opacity-75" id="date-string">Memuat tanggal...</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary px-3 py-2 rounded-pill border border-light shadow-sm">
                            <i class="bi bi-mortarboard me-1"></i> Mode: Siswa Per Kelas
                        </span>
                    </div>
                </div>
            </div>

            {{-- Filter Kelas --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-filter-left me-2"></i>Filter Data Siswa</h6>
                    <form action="{{ route('siswa.perkelas') }}" method="GET" class="row g-3">
                        <div class="col-md-9">
                            <label class="small fw-bold mb-2 text-muted">PILIH KELAS & JURUSAN</label>
                            <select name="kelas_id" class="form-select border-0 bg-light rounded-3 shadow-none">
                                <option value="" disabled {{ !request('kelas_id') ? 'selected' : '' }}>-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->kelas }} {{ $k->nama_kelas }} - {{ $k->jurusan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm fw-bold">
                                <i class="bi bi-search me-1"></i> Tampilkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table Data --}}
            <div class="card border-0 shadow-sm p-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Daftar Siswa</h5>
                    @if(request('kelas_id'))
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill small">
                        Total: {{ $siswa_per_kelas->count() }} Siswa
                    </span>
                    @endif
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4 border-0">NIS/Nama</th>
                                <th class="border-0">JK</th>
                                <th class="border-0">Kelas</th>
                                <th class="border-0">Kontak</th>
                                <th class="border-0 text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa_per_kelas as $s)
                            <tr>
                                <td class="ps-4 py-3">
                                    <span class="fw-bold d-block text-primary small">{{ $s->nis }}</span>
                                    <span class="fw-bold text-dark text-uppercase">{{ $s->nama }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $s->jenis_kelamin == 'L' ? 'bg-info' : 'bg-danger' }} bg-opacity-10 {{ $s->jenis_kelamin == 'L' ? 'text-info' : 'text-danger' }} rounded-pill px-3 py-2" style="font-size: 11px;">
                                        {{ $s->jenis_kelamin == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}
                                    </span>
                                </td>
                                <td class="small">
                                    {{ $s->kelasRelasi->kelas ?? '' }} {{ $s->kelasRelasi->nama_kelas ?? '' }}
                                </td>
                                <td>
                                    @if($s->no_hp)
                                        <a href="https://wa.me/{{ $s->no_hp }}" target="_blank" class="btn btn-sm btn-light text-success rounded-pill border shadow-xs">
                                            <i class="bi bi-whatsapp me-1"></i> Hubungi
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-light btn-sm rounded-circle text-info border shadow-sm" data-bs-toggle="modal" data-bs-target="#viewSiswa{{ $s->id }}"><i class="bi bi-eye"></i></button>
                                        <button class="btn btn-light btn-sm rounded-circle text-primary border shadow-sm" data-bs-toggle="modal" data-bs-target="#editSiswa{{ $s->id }}"><i class="bi bi-pencil-square"></i></button>
                                        <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" id="delete-form-{{ $s->id }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-light btn-sm rounded-circle text-danger border shadow-sm" onclick="confirmDelete({{ $s->id }})"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- MODAL VIEW & EDIT TETAP DI SINI (Sama seperti sebelumnya) --}}
                            {{-- ... --}}

                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-search d-block mb-2" style="font-size: 2rem;"></i>
                                    Pilih kelas untuk menampilkan data siswa.
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

{{-- MODAL-MODAL --}}
@foreach($siswa_per_kelas as $s)
    {{-- MODAL EDIT --}}
    <div class="modal fade" id="editSiswa{{ $s->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-header border-0 px-4 pt-4">
                    <h5 class="fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Data Siswa</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('siswa.update', $s->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body px-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold mb-1">NIS</label>
                                <input type="text" name="nis" class="form-control bg-light border-0 py-2" value="{{ $s->nis }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold mb-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select bg-light border-0 py-2" required>
                                    <option value="L" {{ $s->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ $s->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold mb-1">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control bg-light border-0 py-2 text-uppercase" value="{{ $s->nama }}" required>
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold mb-1">Kelas</label>
                                <select name="kelas" class="form-select bg-light border-0 py-2" required>
                                    @foreach($kelas as $k_item)
                                        <option value="{{ $k_item->id }}" {{ $s->kelas == $k_item->id ? 'selected' : '' }}>
                                            {{ $k_item->kelas }} {{ $k_item->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function updateTime() {
        const now = new Date();
        document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID');
        document.getElementById('date-string').innerText = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    }
    setInterval(updateTime, 1000);
    updateTime();

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus data?',
            text: "Data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) { document.getElementById('delete-form-' + id).submit(); }
        });
    }
</script>

<style>
    .table tbody tr:hover { background-color: #fbfbfb; }
    .form-control:focus, .form-select:focus { box-shadow: none !important; background-color: #f0f2f5 !important; }
</style>
@endsection