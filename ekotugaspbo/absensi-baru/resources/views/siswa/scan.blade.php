@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-camera me-2"></i> SCAN KARTU SISWA</h5>
                </div>
                <div class="card-body p-0 bg-dark">
                    <div id="reader" style="width: 100%;"></div>
                </div>
                <div class="card-footer bg-white p-4">
                    <div id="status-text">
                        <p class="text-muted mb-0">Silahkan arahkan QR Code pada kartu ke kamera</p>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-center gap-3">
                <div class="badge bg-light text-dark border p-2 px-3 shadow-sm">
                    <small class="d-block opacity-75">Sesi Masuk</small>
                    <span class="fw-bold">{{ $jamMasuk->mulai ?? '--' }} - 11:59</span>
                </div>
                <div class="badge bg-light text-dark border p-2 px-3 shadow-sm">
                    <small class="d-block opacity-75">Sesi Pulang</small>
                    <span class="fw-bold">{{ $jamPulang->mulai ?? '--' }} - {{ $jamPulang->selesai ?? '--' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<audio id="beep" src="https://assets.mixkit.co/active_storage/sfx/700/700-preview.mp3"></audio>

<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const beep = document.getElementById('beep');

    function onScanSuccess(decodedText, decodedResult) {
        // Stop scanner bentar biar gak nge-loop scan
        html5QrcodeScanner.pause(true);
        beep.play();

        // Kirim data ke Controller
        fetch("{{ route('proses.scan') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                qr_code: decodedText
            })
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                icon: data.status === 'success' ? 'success' : (data.status === 'warning' ? 'warning' : 'error'),
                title: data.status.toUpperCase(),
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                // Lanjut scan lagi buat murid berikutnya
                html5QrcodeScanner.resume();
            });
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Gagal terhubung ke server', 'error').then(() => {
                html5QrcodeScanner.resume();
            });
        });
    }

    // Setting Scanner
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { 
            fps: 10, 
            qrbox: {width: 250, height: 250},
            aspectRatio: 1.0 
        }
    );
    html5QrcodeScanner.render(onScanSuccess);
</script>

<style>
    /* Styling biar rapih tombol start-nya */
    #reader { border: none !important; }
    #reader__dashboard_section_csr button {
        background-color: #0d6efd !important;
        color: white !important;
        border: none !important;
        padding: 10px 25px !important;
        border-radius: 10px !important;
        font-weight: bold;
        margin: 20px 0 !important;
        cursor: pointer;
    }
    video { border-radius: 0 !important; width: 100% !important; }
</style>
@endsection