@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        {{-- SIDEBAR AREA --}}
        <div class="col-md-3 mb-4">
            @include('layouts.sidebar')
        </div>

        {{-- MAIN CONTENT AREA --}}
        <div class="col-md-9">
            {{-- Header & Filter --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">Log Absensi Siswa</h5>
                            <small class="text-muted">Kelola kehadiran harian - {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</small>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <form action="{{ route('absensi.generateAlpa') }}" method="POST" onsubmit="return confirm('Tutup absen hari ini? Siswa yang belum scan akan otomatis set ALPA.')">
                                @csrf
                                <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                                <button type="submit" class="btn btn-danger rounded-3 shadow-sm px-3">
                                    <i class="bi bi-person-x me-1"></i> Tutup Absen
                                </button>
                            </form>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 d-flex align-items-center">
                                <i class="bi bi-broadcast me-2"></i> Real-time
                            </span>
                        </div>
                    </div>
                    
                    <hr class="text-muted opacity-25 mb-4">

                    <form action="{{ route('absensi.index') }}" method="GET" class="row g-2">
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted mb-1">Pilih Tanggal</label>
                            <input type="date" name="tanggal" class="form-control rounded-3 border-light shadow-sm bg-light" value="{{ $tanggal }}">
                        </div>
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted mb-1">Pilih Kelas</label>
                            <select name="kelas_id" class="form-select rounded-3 border-0 bg-light py-2 shadow-sm">
                                <option value="">Semua Kelas</option>
                                @foreach($daftar_kelas as $k)
                                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->kelas }} {{ $k->nama_kelas }} 
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-sm">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Table --}}
            <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-muted small border-bottom">
                                <th>SISWA</th>
                                <th>KELAS</th>
                                <th>JAM ABSEN</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absensi as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center py-1">
                                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <div>
                                            <span class="fw-bold d-block text-dark">{{ $item->siswa->nama ?? 'Tidak Dikenal' }}</span>
                                            <small class="text-muted">NIS: {{ $item->siswa->nis ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark">
                                        {{ $item->siswa->kelas_relasi->kelas ?? $item->siswa->kelas ?? '-' }} 
                                        {{ $item->siswa->kelas_relasi->nama_kelas ?? '' }}
                                    </span>
                                </td>
                                <td class="text-dark fw-medium">{{ $item->jam_masuk ?? '--:--' }}</td>
                                <td class="text-center">
                                    @php
                                        $status = ucfirst(strtolower($item->status));
                                        $badgeColor = [
                                            'Hadir' => 'success', 
                                            'Terlambat' => 'warning', 
                                            'Izin' => 'info', 
                                            'Sakit' => 'primary', 
                                            'Alpa' => 'danger'
                                        ][$status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }} bg-opacity-10 text-{{ $badgeColor }} rounded-pill px-3 py-2" style="min-width: 80px;">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editStatus{{ $item->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('absensi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Modal Update Status --}}
                                    <div class="modal fade" id="editStatus{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                                                <div class="modal-header border-0 pb-0">
                                                    <h6 class="fw-bold mb-0">Ubah Status</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('absensi.updateStatus', $item->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <div class="modal-body text-start">
                                                        <label class="small text-muted mb-2">Status Kehadiran {{ $item->siswa->nama ?? 'Siswa' }}</label>
                                                        <select name="status" class="form-select rounded-3">
                                                            @foreach(['Hadir', 'Terlambat', 'Izin', 'Sakit', 'Alpa'] as $st)
                                                                <option value="{{ $st }}" {{ $status == $st ? 'selected' : '' }}>{{ $st }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer border-0 pt-0">
                                                        <button type="submit" class="btn btn-primary w-100 rounded-3">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada data absensi untuk filter ini.
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
@endsection