<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Absensi - {{ $siswa->nama }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { width: 350px; background: #fff; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); overflow: hidden; border: 1px solid #ddd; position: relative; }
        .header { background: #0d6efd; color: white; padding: 20px; text-align: center; }
        .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 5px 0 0; font-size: 12px; opacity: 0.9; }
        .content { padding: 25px; text-align: center; }
        .qr-code { background: #f9f9f9; padding: 15px; border-radius: 10px; display: inline-block; margin-bottom: 20px; border: 1px dashed #ccc; }
        .info { text-align: left; margin-top: 10px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; }
        .label { color: #666; }
        .value { font-weight: bold; color: #333; }
        .footer { background: #f8f9fa; padding: 10px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; }
        
        /* Gaya khusus saat diprint */
        @media print {
        body { background: white; padding: 0; margin: 0; }
        .card { 
            box-shadow: none; 
            border: 1px solid #000; 
            page-break-inside: avoid;
        }
        .header { 
            background-color: #0d6efd !important; 
            -webkit-print-color-adjust: exact; /* Biar warna biru header tetep muncul di printer */
        }
    }
    
    /* Tambahin efek transisi biar pas dibuka di layar keliatan smooth */
    .card { transition: transform 0.3s; }
    .card:hover { transform: translateY(-5px); }
    </style>
</head>
<body onload="window.print()">
    <div class="card">
        <div class="header">
            <h2>Kartu Absensi Digital</h2>
            <p>SMK Negeri 1 Bantarkawung</p>
        </div>
        <div class="content">
                        <div class="qr-code">
                @php
                    // 1. Ambil Secret Key dari database
                    $sKey = \App\Models\Setting::where('key', 'qr_key')->first()->value ?? 'PICISAN2025';
                    
                    // 2. Gabungin NISN dan Secret Key dengan pemisah pipe (|)
                    // Hasilnya nanti misal: 0012345678|PICISAN2025
                    $qrData = $user->nisn . '|' . $sKey;
                    
                    // 3. URL Encode biar karakter aman masuk ke URL API QR
                    $finalData = urlencode($qrData);
                @endphp
                
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $finalData }}" alt="QR Code Absensi">
            </div>
            <div class="info">
                <div class="info-row">
                    <span class="label">Nama:</span>
                    <span class="value">{{ $siswa->nama }}</span>
                </div>
                <div class="info-row">
                    <span class="label">NISN:</span>
                    <span class="value">{{ $user->nisn }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Kelas:</span>
                    <span class="value">{{ $siswa->kelasRelasi->nama_kelas ?? 'Kelas Tidak Ditemukan' }}</span>
                </div>
            </div>
        </div>
        <div class="footer">
            Kartu ini digunakan untuk scan absensi harian.
        </div>
    </div>
</body>
</html>