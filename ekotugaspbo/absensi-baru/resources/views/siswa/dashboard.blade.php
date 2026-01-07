@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm p-3 mb-4" style="border-radius: 15px;">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama) }}&background=0D6EFD&color=fff&size=100" class="rounded-circle shadow-sm" alt="Profile">
                    </div>
                    <h5 class="fw-bold mb-1">{{ $siswa->nama }}</h5>
                    <p class="text-muted small mb-3">Kelas: {{ $siswa->kelasRelasi->nama_kelas ?? 'Kelas Tidak Ditemukan' }}</p>
                    
                    <a href="{{ route('siswa.cetak') }}" target="_blank" class="btn btn-outline-dark btn-sm w-100 mb-3" style="border-radius: 10px;">
                        <i class="bi bi-printer me-2"></i> Cetak Kartu QR
                    </a>

                    <hr>
                    
                    <div class="text-start mb-4">
                        <div class="mb-2">
                            <small class="text-muted d-block small-label">NISN / Username</small>
                            <span class="fw-bold text-primary">{{ $user->nisn }}</span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block small-label">Tanggal Lahir</small>
                            <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($siswa->tgl_lahir)->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block small-label">Nomor HP</small>
                            <span class="fw-bold text-dark">{{ $siswa->no_hp ?? '-' }}</span>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm w-100 text-danger fw-bold border" style="border-radius: 10px;">
                            <i class="bi bi-box-arrow-right me-2"></i> Keluar Aplikasi
                        </button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
                <h6 class="fw-bold mb-3"><i class="bi bi-envelope-paper me-2"></i>Form Izin / Sakit</h6>
                <form action="{{ route('siswa.izin') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="small fw-bold">Keterangan</label>
                        <select name="keterangan" class="form-select form-select-sm" required>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Alasan</label>
                        <textarea name="alasan" class="form-control form-control-sm" rows="3" placeholder="Contoh: Sakit, urusan keluarga..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger btn-sm w-100 shadow-sm" style="border-radius: 8px;">
                        Kirim Permohonan Izin
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row mb-4">
                <div class="col-md-4 mb-2">
                    <div class="card border-0 bg-success text-white shadow-sm" style="border-radius: 15px;">
                        <div class="card-body p-3">
                            <small class="d-block opacity-75">Total Hadir</small>
                            <h3 class="fw-bold mb-0">{{ $hadir }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="card border-0 bg-warning text-dark shadow-sm" style="border-radius: 15px;">
                        <div class="card-body p-3">
                            <small class="d-block opacity-75">Total Izin/Sakit</small>
                            <h3 class="fw-bold mb-0">{{ $izin }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="card border-0 bg-danger text-white shadow-sm" style="border-radius: 15px;">
                        <div class="card-body p-3">
                            <small class="d-block opacity-75">Total Alpa</small>
                            <h3 class="fw-bold mb-0">{{ $alpa }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Status Absensi Hari Ini</h5>
                    @if($absen)
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 border {{ $absen->jam_masuk ? 'border-success bg-light text-success' : 'border-secondary' }}" style="border-radius: 12px;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="fw-bold text-uppercase small">Jam Masuk</small>
                                        <i class="bi bi-box-arrow-in-right fs-4"></i>
                                    </div>
                                    <h3 class="fw-bold mt-2 mb-0">{{ $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') : '--:--' }}</h3>
                                    <small>{{ $absen->jam_masuk ? 'Sudah Scan di Gerbang' : 'Belum Terdeteksi' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border {{ $absen->jam_pulang ? 'border-info bg-light text-info' : 'border-secondary' }}" style="border-radius: 12px;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="fw-bold text-uppercase small">Jam Pulang</small>
                                        <i class="bi bi-box-arrow-left fs-4"></i>
                                    </div>
                                    <h3 class="fw-bold mt-2 mb-0">{{ $absen->jam_pulang ? \Carbon\Carbon::parse($absen->jam_pulang)->format('H:i') : '--:--' }}</h3>
                                    <small>{{ $absen->jam_pulang ? 'Sudah Scan Pulang' : 'Belum Scan Pulang' }}</small>
                                </div>
                            </div>
                        </div>
                       @if($absen->status != 'Hadir')
    {{-- Kalau statusnya PENDING, kasih warna kuning (warning), kalau sudah fix kasih biru (info) --}}
    <div class="alert {{ $absen->status == 'PENDING' ? 'alert-warning' : 'alert-info' }} mt-4 border-0 mb-0">
        <i class="bi {{ $absen->status == 'PENDING' ? 'bi-hourglass-split' : 'bi-info-circle' }} me-2"></i> 
        Status hari ini: <strong>{{ $absen->status }}</strong> 
        <br>
        <small class="ms-4">{{ $absen->alasan }}</small>
    </div>
@endif
                    @else
                        <div class="alert alert-secondary border-0 d-flex align-items-center mb-0" role="alert" style="border-radius: 12px;">
                            <i class="bi bi-qr-code fs-4 me-3"></i>
                            <div>Silahkan lakukan scan kartu pada alat yang tersedia di sekolah.</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">5 Aktivitas Terakhir</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr class="small text-uppercase">
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Jam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $dataAbsen = \App\Models\Absensi::where('siswa_id', $siswa->id)->get();
    
                                    // 2. Ambil data dari tabel Izin TAPI hanya yang statusnya 'Pending' 
                                    // (Supaya tidak double dengan yang sudah masuk ke tabel Absensi)
                                    $dataIzinPending = \App\Models\Izin::where('siswa_id', $siswa->id)
                                                                        ->where('status', 'Pending')
                                                                        ->get();

                                    // 3. Gabungkan keduanya
                                    $riwayat = $dataAbsen->concat($dataIzinPending->map(function($i){
                                        return (object)[
                                            'tanggal' => $i->tanggal_mulai,
                                            'status' => $i->jenis_izin, // Misal: 'Izin' atau 'Sakit'
                                            'is_pending' => true,      // Penanda buat warna badge nanti
                                            'alasan' => $i->keterangan,
                                            'jam_masuk' => null,
                                            'jam_pulang' => null
                                        ];
                                    }))->sortByDesc('tanggal')->take(5);
                                @endphp
                                @forelse($riwayat as $r)
                                <tr>
                                    <td class="small">{{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}</td>
                                    <td>
    {{-- Cek apakah data ini datang dari tabel Izin (is_pending) atau tabel Absensi --}}
    @if(isset($r->is_pending) && $r->is_pending)
        <span class="badge bg-warning text-dark">PENDING</span>
    @else
        <span class="badge {{ in_array($r->status, ['Hadir', 'Terlambat']) ? 'bg-success' : ($r->status == 'Alpa' ? 'bg-danger' : 'bg-info') }}">
    {{ $r->status }}
</span>
    @endif
</td>
                                    <td class="small font-monospace">
                                        @if($r->status == 'Hadir')
                                            {{-- Jika hadir, tampilkan jam scan --}}
                                            <span class="text-success">{{ $r->jam_masuk ?? '--:--' }}</span> | <span class="text-info">{{ $r->jam_pulang ?? '--:--' }}</span>
                                        @else
                                            {{-- Jika Izin/Sakit/Alpa atau Pending, tampilkan alasannya --}}
                                            <span class="text-muted">
                                                <i class="bi bi-chat-left-text me-1"></i> 
                                                {{ $r->alasan ?? 'Tanpa alasan' }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-4 text-muted">Belum ada riwayat absensi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div> 
</div> 
@endsection