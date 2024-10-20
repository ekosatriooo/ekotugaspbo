<?php
class Buah {
    public $nama;
    public $warna;

    function __construct($nama, $warna) {
        $this->nama = $nama;
        $this->warna = $warna;
    }
    function get_nama() {
        return $this->nama;
    }
    function get_warna() {
        return $this->warna;
    }
}

$apel = new Buah("Apel", "Merah");
echo $apel->get_nama();
echo "<br>";
echo $apel->get_warna();
?>