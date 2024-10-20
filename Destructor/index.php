<?php
class Mahasiswa {
    public $nama;
    public $tinggi;
    public $warna;

    function __construct($nama, $tinggi, $warna) {
        $this->nama = $nama;
        $this->tinggi = $tinggi;
        $this->warna = $warna;
    }
    function __destruct() {
        echo "Mahasiswa tersebut bernama {$this->nama}, tinggi badan {$this->tinggi} , dan warna kulit {$this->warna}.<br>";
    }
}

$SevaKhairulRohmanBaskoro = new Mahasiswa("Seva Khairul Rohman Baskoro", "400 cm", "hijau");
$IbnuKholif = new Mahasiswa("Ibnu Kholif", "300 cm", "kuning");
$EkoSatrio = new Mahasiswa("Eko Satrio", "200 cm", "merah");
?>