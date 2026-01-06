@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        {{-- SIDEBAR --}}
        <div class="col-md-3 mb-4">
            @include('layouts.sidebar')
        </div>

        {{-- KONTEN UTAMA --}}
        <div class="col-md-9">
            {{-- HEADER WIDGET --}}
            <div class="card border-0 shadow-sm mb-4 bg-dark text-white" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0" id="clock">00:00:00</h4>
                        <p class="mb-0 opacity-75" id="date-string">Memuat tanggal...</p>
                    </div>
                    <div class="text-end">
                        <h5 class="fw-bold mb-0">Konfirmasi Izin</h5>
                        <span class="badge bg-warning text-dark rounded-pill">
                            <i class="bi bi-info-circle me-1"></i> Perlu Review
                        </span>
                    </div>
                </div>
            </div>

            {{-- TABLE CARD --}}
            <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-envelope-paper text-primary me-2"></i>Daftar Pengajuan Izin</h5>
                    <div class="input-group style="width: 250px;">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Cari nama siswa...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-3">Siswa</th>
                                <th class="border-0">Tipe</th>
                                <th class="border-0">Keterangan</th>
                                <th class="border-0">Status</th>
                                <th class="border-0 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data_izin as $izin)
                            <tr>
                                <td class="px-3">
                                    <div class="fw-bold text-dark">{{ $izin->siswa->nama }}</div>
                                    <small class="text-muted">{{ $izin->siswa->kelas_relasi->nama_kelas ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ $izin->jenis_izin == 'Sakit' ? 'bg-primary' : 'bg-info' }} rounded-pill px-3">
                                        {{ $izin->jenis_izin }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted d-block" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $izin->keterangan }}
                                    </small>
                                </td>
                                <td>
                                    @if($izin->status == 'Pending')
                                        <span class="badge bg-soft-warning text-warning border border-warning px-2 py-1" style="background-color: #fff9e6;">
                                            <i class="bi bi-clock-history me-1"></i> Pending
                                        </span>
                                    @elseif($izin->status == 'Disetujui')
                                        <span class="badge bg-soft-success text-success border border-success px-2 py-1" style="background-color: #e6ffed;">
                                            <i class="bi bi-check-circle me-1"></i> Disetujui
                                        </span>
                                    @else
                                        <span class="badge bg-soft-danger text-danger border border-danger px-2 py-1" style="background-color: #ffe6e6;">
                                            <i class="bi bi-x-circle me-1"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-primary rounded-3" data-bs-toggle="modal" data-bs-target="#modalBukti{{ $izin->id }}" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        @if($izin->status == 'Pending')
                                            <form action="{{ route('izin.setujui', $izin->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success rounded-3" onclick="return confirm('Setujui izin ini?')">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('izin.tolak', $izin->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger rounded-3" onclick="return confirm('Tolak izin ini?')">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- MODAL DETAIL BUKTI --}}
                            <div class="modal fade" id="modalBukti{{ $izin->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="fw-bold">Detail Pengajuan Izin</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="small text-muted mb-1">Nama Siswa</label>
                                                <p class="fw-bold mb-0 text-dark">{{ $izin->siswa->nama }} ({{ $izin->siswa->kelas_relasi->nama_kelas ?? 'N/A' }})</p>
                                            </div>
                                            <div class="mb-4">
                                                <label class="small text-muted mb-1">Alasan / Keterangan</label>
                                                <div class="p-3 bg-light rounded-3 italic">
                                                    "{{ $izin->keterangan }}"
                                                </div>
                                            </div>
                                            
                                            <label class="small text-muted mb-2">Lampiran Bukti</label>
                                            <div class="text-center bg-light rounded-3 p-2 overflow-hidden">
                                                @if($izin->bukti)
                                                    <img src="{{ asset('storage/bukti_izin/' . $izin->bukti) }}" class="img-fluid rounded-3 zoom-effect" alt="Bukti Izin">
                                                @else
                                                    <div class="py-5 text-muted">
                                                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                                                        Tidak ada lampiran gambar
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                    Belum ada data pengajuan izin hari ini.
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
    .table thead th { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #8898aa; border-bottom: none; }
    .zoom-effect { transition: transform .3s; cursor: pointer; }
    .zoom-effect:hover { transform: scale(1.02); }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .bg-soft-success { background-color: rgba(40, 167, 69, 0.1); }
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); }
</style>
@endsection