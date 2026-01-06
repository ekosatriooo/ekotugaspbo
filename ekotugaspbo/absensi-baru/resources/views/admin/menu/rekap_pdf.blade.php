<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi {{ $bulan }}-{{ $tahun }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 14px; }
        
        .info { margin-bottom: 20px; }
        .info table { border: none; width: auto; }
        .info td { border: none; padding: 2px 10px 2px 0; font-weight: bold; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f2f2f2; border: 1px solid #444; padding: 10px; text-transform: uppercase; font-size: 11px; }
        td { border: 1px solid #444; padding: 8px; text-align: center; }
        .text-left { text-align: left; }
        
        .footer { margin-top: 30px; float: right; width: 200px; text-align: center; }
        .footer p { margin-bottom: 60px; }
        
        .page-number:before { content: "Halaman " counter(page); }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Rekapitulasi Absensi Siswa</h2>
        <p>SMA Negeri 1 Bantarkawung</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td>Periode</td>
                <td>: {{ \Carbon\Carbon::create()->month((int)$bulan)->translatedFormat('F') }}</td>
            </tr>
            <tr>
                <td>Total Siswa</td>
                <td>: {{ $rekap->count() }} Orang</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Siswa</th>
                <th width="15%">Kelas</th>
                <th width="10%">Hadir</th>
                <th width="10%">Sakit</th>
                <th width="10%">Izin</th>
                <th width="10%">Alpa</th>
                <th width="10%">%</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($rekap as $r)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-left">{{ $r->nama }}</td>
                <td>{{ $r->kelasRelasi->kelas ?? '' }} {{ $r->kelasRelasi->nama_kelas ?? 'Kelas Tidak Ditemukan' }}</td>
                <td>{{ $r->hadir }}</td>
                <td>{{ $r->sakit }}</td>
                <td>{{ $r->izin }}</td>
                <td style="{{ $r->alpa > 0 ? 'color: red; font-weight: bold;' : '' }}">{{ $r->alpa }}</td>
                <td style="font-weight: bold;">{{ $r->persentase }}%</td>
            </tr>
            @empty
            <tr>
                <td colspan="8">Data tidak ditemukan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y') }}<br>Administrator,</p>
        <br>
        <strong>( ........................... )</strong>
    </div>

</body>
</html>