@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        {{-- SIDEBAR --}}
        <div class="col-md-3 mb-4">
            @include('layouts.sidebar') {{-- Anggap sidebar sudah dipisah ke partial --}}
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
                            <i class="bi bi-graph-up-arrow me-1"></i> Mode: Rekapitulasi Laporan
                        </span>
                    </div>
                </div>
            </div>

            {{-- STATS CARDS --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 border-start border-primary border-4" style="border-radius: 15px;">
                        <small class="text-muted fw-bold d-block mb-1 text-uppercase">Total Siswa Terdata</small>
                        <div class="d-flex align-items-center">
                            <h3 class="fw-bold mb-0 me-2">{{ $rekap->count() }}</h3>
                            <span class="text-muted small">Siswa</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 border-start border-success border-4" style="border-radius: 15px;">
                        <small class="text-muted fw-bold d-block mb-1 text-uppercase">Rata-rata Hadir</small>
                        <div class="d-flex align-items-center">
                            <h3 class="fw-bold mb-0 text-success me-2">{{ number_format($rekap->avg('persentase'), 1) }}%</h3>
                            <i class="bi bi-arrow-up-right text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 border-start border-danger border-4" style="border-radius: 15px;">
                        <small ...>Total Alpa ({{ Carbon\Carbon::create()->month((int)$bulan)->translatedFormat('F') }})</small>
                        <div class="d-flex align-items-center">
                            <h3 class="fw-bold mb-0 text-danger me-2">{{ $rekap->sum('alpa') }}</h3>
                            <span class="text-muted small">Kali</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter Rekap --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-filter-left me-2"></i>Filter Laporan</h6>
                    <form action="{{ route('rekap.index') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="small fw-bold mb-2 text-muted">BULAN</label>
                            <select name="bulan" class="form-select border-0 bg-light rounded-3 shadow-none">
                                @for ($m=1; $m<=12; $m++)
                                    <option value="{{ sprintf('%02d', $m) }}" {{ $bulan == sprintf('%02d', $m) ? 'selected' : '' }}>
                                        {{ Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="small fw-bold mb-2 text-muted">TAHUN</label>
                            <select name="tahun" class="form-select border-0 bg-light rounded-3 shadow-none">
                                @for ($y=date('Y'); $y>=2024; $y--)
                                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="small fw-bold mb-2 text-muted">KELAS</label>
                            <select name="kelas" class="form-select border-0 bg-light rounded-3 shadow-none">
                                <option value="">-- Semua Kelas --</option>
                                @foreach($daftar_kelas as $k)
                                    <option value="{{ $k->id }}" {{ request('kelas') == $k->id ? 'selected' : '' }}>
                                        {{ $k->kelas }} {{ $k->nama_kelas }} 
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

            {{-- Table Rekap --}}
            <div class="card border-0 shadow-sm p-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Tabel Kehadiran Siswa</h5>
                    <div class="btn-group">
                        <a href="{{ route('rekap.pdf', ['bulan' => $bulan, 'tahun' => $tahun, 'kelas' => request('kelas')]) }}" class="btn btn-danger btn-sm rounded-start-pill px-3">
                            <i class="bi bi-file-pdf me-1"></i> PDF
                        </a>
                        <button class="btn btn-success btn-sm rounded-end-pill px-3">
                            <i class="bi bi-file-earmark-excel me-1"></i> Excel
                        </button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4 border-0">SISWA</th>
                                <th class="border-0 text-center">HADIR</th>
                                <th class="border-0 text-center">SAKIT</th>
                                <th class="border-0 text-center">IZIN</th>
                                <th class="border-0 text-center">ALPA</th>
                                <th class="border-0 text-center pe-4">PERSENTASE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekap as $r)
                            <tr>
                                <td class="ps-4 py-3">
                                    <span class="fw-bold d-block text-dark">{{ $r->nama }}</span>
                                    <small class="text-muted text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">
                                        {{ $r->kelasRelasi->kelas ?? '' }} {{ $r->kelasRelasi->nama_kelas ?? 'N/A' }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">{{ $r->hadir }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">{{ $r->sakit }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">{{ $r->izin }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">{{ $r->alpa }}</div>
                                </td>
                                <td class="text-center pe-4">
                                    @php
                                        $bgClass = 'bg-primary';
                                        if($r->persentase < 75) $bgClass = 'bg-danger';
                                        elseif($r->persentase < 90) $bgClass = 'bg-warning text-dark';
                                    @endphp
                                    <div class="progress" style="height: 6px; width: 80px; margin: 0 auto 5px auto;">
                                        <div class="progress-bar {{ str_replace('text-dark', '', $bgClass) }}" role="progressbar" style="width: {{ $r->persentase }}%"></div>
                                    </div>
                                    <span class="fw-bold {{ str_contains($bgClass, 'warning') ? 'text-warning' : str_replace('bg-', 'text-', $bgClass) }}" style="font-size: 0.85rem;">
                                        {{ $r->persentase }}%
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-clipboard-x d-block mb-2" style="font-size: 2rem;"></i>
                                    Data tidak ditemukan untuk periode ini.
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
    .progress { background-color: #f0f2f5; border-radius: 10px; }
    .table tbody tr:hover { background-color: #fbfbfb; }
    .badge { font-weight: 600; }
</style>
@endsection