<!DOCTYPE html>
<html>
<head>
        <title>EkoPBO</title>
        <h2 style="color: blue;" align=""left"">Pertemuan-1 </h1>
    </head>
    <body></body>

        <h1>Pemrograman Berorientasi Objek</h1>
        <p><b>1. Pengertian</p></b>
        <p>Pemrograman berorientasi objek (Inggris: object-oriented programming disingkat OOP)<br>
            merupakan paradigma pemrograman berdasarkan konsep "objek", yang dapat berisi data, dalam<br>
            bentuk field atau dikenal juga sebagai atribut; serta kode, dalam bentuk fungsi/prosedur atau<br>
            dikenal juga sebagai method. Semua data dan fungsi di dalam paradigma ini dibungkus dalam<br>
            kelas-kelas atau objek-objek. Bandingkan dengan logika pemrograman terstruktur. Setiap objek<br>
            dapat menerima pesan, memproses data, dan mengirim pesan ke objek lainnya,</p>
            <p><b>2. Bahasa Pemrograman Yang mendukung PBO</p></b>
            <p>Berikut ini adalah Bahasa pemrograman yang mendukung OOP antara lain seperti:</p>
            <ul>
                <li>Visual Foxpro</li>
                <li>Java</li>
                <li>C++</li>
                <li>Pascal (bahasa pemrograman)</li>
                <li>SIMULA</li>
                <li>Smalltalk</li>
                <li>Ruby</li>
                <li>Python</li>
                <li>PHP</li>
                <li>TypeScript</li>
                <li>C#</li>
                <li>Delphi</li>
                <li>Eiffel</li>
                <li>Perl</li>
                <li>Adobe Flash AS 3.0</li>
            </ul>
            <p><b>3. Membuat Tabel kategori Produk</b></p>
            <!DOCTYPE html>
<html>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
<body>
<table style="width:20%">
  <tr>
    <th>NO</th>
    <th>Kategori Produk</th> 
    <th>Nama Produk</th>
  </tr>
  <tr>
    <td>1</td>
    <td>Bumbu Dapur</td>
    <td>Garam</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Bumbu Dapur</td>
    <td>Cabe</td>
  </tr>
  <tr>
    <td>3</td>
    <td>Bumbu Dapur</td>
    <td>Lengkuas</td>
  </tr>
  <tr>
    <td>4</td>
    <td>Bumbu Dapur</td>
    <td>Terasi</td>
    <tr>
        <td>5</td>
        <td>Sembako</td>
        <td>Beras</td>
        <tr>
            <td>6</td>
            <td>Sembako</td>
            <td>Minyak goreng</td>
        </tr>
        <tr>
            <td>6</td>
            <td>Sembako</td>
            <td>Gula pasir</td>
        </tr>
</table>

    </body>
</html>
<p><b>4. Membuat Tabel Produk</b></p>
<!DOCTYPE html>
<html>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
<body>
<table style="width:20%">
  <tr>
    <th>NO</th>
    <th>Produk</th> 
    <th>Stok</th>
    <th>Harga</th>
  </tr>
  <tr>
    <td>1</td>
    <td>Garam</td>
    <td>10</td>
    <td>7000</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Cabe</td>
    <td>10</td>
    <td>25000</td>
  </tr>
  <tr>
    <td>3</td>
    <td>Lengkuas</td>
    <td>10</td>
    <td>12000</td>
  </tr>
  <tr>
    <td>4</td>
    <td>Terasi</td>
    <td>10</td>
    <td>35000</td>
    <tr>
        <td>5</td>
        <td>Beras</td>
        <td>10</td>
        <td>13000</td>
        <tr>
            <td>6</td>
            <td>Minyak goreng</td>
            <td>10</td>
            <td>15000</td>
        </tr>
        <tr>
            <td>6</td>
            <td>Gula pasir</td>
            <td>10</td>
            <td>13000</td>
        </tr>
</table>

    </body>
</html>
    </body>
</html>

<h2 style="color: blue;" align=""left"">Pertemuan-3 </h1>

<h3 style="color: black;" align=""left"">Membuat kelas "Buah" dengan property "nama" dan "warna"</h1>

<br>
<?php
 class Buah {
    // Properties
    public $nama;
    public $warna;

    // Methods
    function set_name($nama) {
        $this->nama = $nama;
    }
    function get_name() {
        return $this->nama;
    }
    function set_warna($warna) {
        $this->warna = $warna;
    }
    function get_warna() {
        return $this->warna;
    }
}

// Membuat objek dari kelas Buah
$apel = new Buah();
$pisang = new Buah();

// Mengatur nama buah
$apel->set_name('Apel');
$pisang->set_name('Pisang');

$apel-> set_warna('Merah');
$pisang->set_warna('Kuning');

// Menampilkan nama buah
echo "nama: " . $apel->get_name();
echo "<br>";
echo "warna: " . $apel->get_warna();
echo "<br>";
echo "nama: " . $pisang->get_name();
echo "<br>";
echo "warna: " . $pisang->get_warna();
?>

<h3 style="color: black;" align=""left"">Membuat kelas "Mobil" dengan objek "toyota" property "warna"</h1>

<?php
            class mobil {
                // Properties
                public $nama;
                public $warna;

                // Methods
                function set_name($nama) {
                    $this->nama = $nama;
                }

                function get_name() {
                    return $this->nama;
                }

                function set_warna($warna) {
                    $this->warna = $warna;
                }

                function get_warna() {
                    return $this->warna;
                }
            }

            // Membuat objek dari kelas mobil
            $toyota = new mobil();

            // Mengatur nama
            $toyota->set_name('toyota');
            $toyota->set_warna('Biru Metalik');

            // Menampilkan nama 
            echo "Nama : " . $toyota->get_name();
            echo "<br>";
            echo "Warna : " . $toyota->get_warna();
        ?>

<h2 style="color: blue;" align=""left"">Pertemuan-4 </h1>
<h3 style="color: black;" align=""left"">Konstruktor dan Destruktor</h1>
<h4 style="color: black;" align=""left"">Konstruktor</h1>

<?php
    class Buah2 {
        public $nama2;
        public $warna2;

        function __construct($nama2, $warna2) {
            $this->nama2 = $nama2;
            $this->warna2 = $warna2;
        }

        function get_nama2() {
            return $this->nama2;
        }

        function get_warna2() {
            return $this->warna2;
        }
    }

    $apel = new Buah2("Apel", "Merah");
    echo $apel->get_nama2() . "<br>";
    echo $apel->get_warna2() . "<br>";
    ?>
<h4 style="color: black;" align=""left"">Destruktor</h1>

<?php
class Buah3 {
    public $nama;
    public $warna;
    function __construct($nama, $warna) {
        $this->nama = $nama;
        $this->warna = $warna;
    }
    function __destruct() {
        echo "Buah tersebut adalah {$this->nama} dan warnanya adalah {$this->warna}."; 
    }
}
$apel = new Buah3("Apel", "Merah");
unset($apel);
?>
<br>
<h2 style="color: black;" align=""left"">TUGAS-PERTEMUAN 4 </h1>
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
unset($SevaKhairulRohmanBaskoro);
unset($IbnuKholif);
unset($EkoSatrio);
?>

<h2 style="color: blue;" align=""left"">Pertemuan-5 </h1>

<h3 style="color: black;" align=""left"">Konstanta dan Abstrak </h1>
<h4 style="color: black;" align=""left"">Konstanta</h1>

<br>
<?php

class komputer {

    const DOLLAR = '12000';
}


echo "Harga dollar saat ini = Rp. ".komputer::DOLLAR;
?>

<br>
<?php
class Selamat_Tinggal {
    const LEAVING_MESSAGE = "Terima kasih sudah berkunjung";
    public function byebye() {
        echo self::LEAVING_MESSAGE;
    }
}

$selamat_tinggal = new Selamat_tinggal();
$selamat_tinggal->byebye();
?>

<h4 style="color: black;" align=""left"">Abstrak</h1>


<?php
abstract class Mobil2 {
    public $nama;
    public function __construct($nama) {
        $this->nama = $nama;
    }
    abstract public function intro() : string;
}

class Audi extends Mobil2 {
    public function intro() : string {
        return "Untuk kualitas terbaik! Saya pilih $this->nama!";
    }
}

class Volvo extends Mobil2 {
    public function intro() : string {
        return "Untuk hemat bahan bakar! Saya pilih $this->nama!";
    }
}

class Citroen extends Mobil2 {
    public function intro() : string {
        return "Untuk purna jual! Saya pilih $this->nama!";
    }
}
$audi = new audi("BWM");
echo $audi->intro();
echo "<br>";

$volvo = new volvo("Panther");
echo $volvo->intro();
echo "<br>";

$citroen = new citroen("Toyota");
echo $citroen->intro();
echo "<br>";
?>

<br>
<?php

abstract class ParentClass {
    abstract protected function prefixName($nama);
}

class ChildClass extends ParentClass {
    public function prefixName($nama) {
        if ($nama == "Ahmad Sulistiyo") {
            $prefix = "Mr.";
        } elseif ($nama == "Siti Aisyah") {
            $prefix = "Miss.";
        }else {
            $prefix = "";
        }
        return "{$prefix} {$nama}";
    }
}

$class = new Childclass;
echo $class->prefixName("Ahmad Sulistiyo");
echo "<br>";
echo $class->prefixName("Siti Aisyah");
echo "<br>";
?>


<?php

abstract class ParentClass2 {
    abstract protected function prefixName($nama);
}

class ChildClass2 extends ParentClass2 {
    public function prefixName($nama, $separator =
     ".", $greet = "Dear") {
        if ($nama == "Ahmad Sulistiyo") {
            $prefix = "Mr";
        } elseif ($nama == "Siti Aisyah") {
            $prefix = "Miss";
        } else {
            $prefix = "";
        }
        return "{$greet} {$prefix} {$separator} {$nama}";
    }
}

$class = new ChildClass2;
echo "<br>";
echo $class->prefixName("Ahmad Sulistiyo");
echo "<br>";
echo $class->prefixName("Siti Aisyah");
?>

<h2 style="color: blue;" align=""left"">Pertemuan-7 </h1>
<h3 style="color: black;" align=""left"">Penjelasan Koding Crud </h1>
