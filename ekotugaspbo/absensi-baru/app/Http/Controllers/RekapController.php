<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        $kelas_id = $request->get('kelas'); // Menangkap ID Kelas dari dropdown

        // AMBIL SEMUA DATA DARI MODEL KELAS (Bukan dari tabel siswa)
        // Biar dropdown isinya Nama Kelas, bukan angka dongok
        $daftar_kelas = Kelas::orderBy('kelas', 'asc')->orderBy('nama_kelas', 'asc')->get();

        $rekap = $this->getDataRekap($bulan, $tahun, $kelas_id);

        return view('admin.menu.rekap', compact('rekap', 'bulan', 'tahun', 'daftar_kelas'));
    }

    public function cetakPdf(Request $request, $bulan, $tahun)
    {
        $kelas = $request->get('kelas');    
        $rekap = $this->getDataRekap($bulan, $tahun, $kelas);
        
        $pdf = Pdf::loadView('admin.menu.rekap_pdf', compact('rekap', 'bulan', 'tahun'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream("rekap-absensi-{$bulan}-{$tahun}.pdf");
    }

    private function getDataRekap($bulan, $tahun, $kelas_id = null)
{
    // WAJIB tambahkan with('kelasRelasi') supaya data nama_kelas bisa tampil
    $query = Siswa::with(['kelasRelasi'])->select('id', 'nama', 'kelas');

    if ($kelas_id) {
        // Karena di model kamu protected $fillable = ['kelas', ...], 
        // maka kita filter kolom 'kelas' (yang isinya ID itu)
        $query->where('kelas', $kelas_id);
    }

    $rekap = $query->withCount([
        'absensi as hadir' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tanggal', $bulan)
                  ->whereYear('tanggal', $tahun)
                  ->whereIn('status', ['Hadir', 'Terlambat']); 
        },
        'absensi as sakit' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tanggal', $bulan)
                  ->whereYear('tanggal', $tahun)
                  ->where('status', 'Sakit');
        },
        'absensi as izin' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tanggal', $bulan)
                  ->whereYear('tanggal', $tahun)
                  ->where('status', 'Izin');
        },
        'absensi as alpa' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tanggal', $bulan)
                  ->whereYear('tanggal', $tahun)
                  ->where('status', 'Alpa');
        }
    ])->get();

    $rekap->transform(function ($item) {
        $totalRecord = $item->hadir + $item->sakit + $item->izin + $item->alpa;
        $item->persentase = $totalRecord > 0 ? round(($item->hadir / $totalRecord) * 100, 1) : 0;
        return $item;
    });

    return $rekap;
}
}