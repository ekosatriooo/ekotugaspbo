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
            {{-- Header Jam & Status --}}
            <div class="card border-0 shadow-sm mb-4 bg-dark text-white" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0" id="clock">00:00:00</h4>
                        <p class="mb-0 opacity-75" id="date-string">Memuat tanggal...</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-danger px-3 py-2 rounded-pill border border-light shadow-sm">
                            <i class="bi bi-calendar-event me-1"></i> Kalender Akademik
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card Tabel & Aksi --}}
            <div class="card border-0 shadow-sm p-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-white border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0">Daftar Hari Libur</h5>
                        <p class="text-muted small">Siswa tidak perlu absen pada tanggal di bawah ini.</p>
                    </div>
                    <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahLibur">
                        <i class="bi bi-calendar-plus me-2"></i> Tambah Libur
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">TANGGAL</th>
                                <th>KETERANGAN</th>
                                <th class="text-center">TIPE</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($holidays as $h)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center py-2">
                                        <div class="bg-danger bg-opacity-10 text-danger p-2 rounded-3 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-calendar-x-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <span class="fw-bold d-block">{{ \Carbon\Carbon::parse($h->holiday_date)->translatedFormat('d F Y') }}</span>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($h->holiday_date)->translatedFormat('l') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark fw-medium">{{ $h->description }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $h->type == 'nasional' ? 'bg-danger' : 'bg-warning text-dark' }} bg-opacity-10 rounded-pill px-3 py-2" style="font-size: 0.75rem;">
                                        {{ strtoupper($h->type) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-light btn-sm rounded-circle shadow-sm border text-danger" onclick="confirmDeleteLibur({{ $h->id }})">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                    <form action="{{ route('libur.destroy', $h->id) }}" method="POST" id="delete-libur-{{ $h->id }}" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="opacity-50 mb-3">
                                        <i class="bi bi-calendar2-check" style="font-size: 3rem;"></i>
                                    </div>
                                    <p class="text-muted">Belum ada hari libur yang diatur. Semua hari dianggap masuk.</p>
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

{{-- MODAL TAMBAH LIBUR --}}
<div class="modal fade" id="modalTambahLibur" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Hari Libur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('libur.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small fw-bold mb-2">PILIH TANGGAL</label>
                        <input type="date" name="holiday_date" class="form-control border-0 bg-light rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold mb-2">KETERANGAN</label>
                        <textarea name="description" class="form-control border-0 bg-light rounded-3" rows="3" placeholder="Contoh: Libur Idul Fitri" required></textarea>
                    </div>
                    <div class="mb-0">
                        <label class="small fw-bold mb-2">TIPE LIBUR</label>
                        <select name="type" class="form-select border-0 bg-light rounded-3">
                            <option value="nasional">Nasional (Warna Merah)</option>
                            <option value="khusus">Khusus Sekolah (Warna Kuning)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Simpan Libur</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Live Clock
    function updateTime() {
        const now = new Date();
        document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID');
        document.getElementById('date-string').innerText = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    }
    setInterval(updateTime, 1000);
    updateTime();

    // SweetAlert Success
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
    @endif

    // Confirm Delete
    function confirmDeleteLibur(id) {
        Swal.fire({
            title: 'Hapus hari libur?',
            text: "Siswa akan diminta absen kembali pada tanggal ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-libur-' + id).submit();
            }
        });
    }
</script>

<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        opacity: 0.6;
    }
    .table tbody tr { transition: 0.3s; }
    .table tbody tr:hover { background-color: rgba(220, 53, 69, 0.02); }
</style>
@endsection