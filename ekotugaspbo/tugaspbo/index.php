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
<h2>index.php</h2>
    <P>
        Kode ini merupakan halaman utama untuk aplikasi manajemen inventaris toko buah "TOKO BUAH EKO". Aplikasi ini dirancang dengan antarmuka sederhana yang memungkinkan pengguna melakukan berbagai operasi CRUD pada data barang</P>
    
        <div>
    <h3>Fitur Utama:</h3>
    <ol>
        <li>
            <strong>Create (Tambah Barang):</strong>
            <ul>
                <li>Tombol "Tambah Barang" akan menampilkan form untuk menambahkan barang baru.</li>
                <li>Proses ini dilakukan melalui file <code>add_data.php</code>.</li>
                <li>Pengguna dapat memasukkan detail barang yang akan disimpan dalam sistem.</li>
            </ul>
        </li>
        <li>
            <strong>Read (Lihat Stok):</strong>
            <ul>
                <li>Tombol "Lihat Stok" menampilkan daftar barang yang tersedia.</li>
                <li>Informasi stok ditampilkan melalui file <code>view.php</code>.</li>
                <li>Memungkinkan pengguna melihat semua barang yang ada di inventaris.</li>
            </ul>
        </li>
        <li>
            <strong>Update (Edit Barang):</strong>
            <ul>
                <li>Menggunakan iframe untuk menampilkan form edit.</li>
                <li>Proses edit dilakukan secara dinamis.</li>
                <li>Memungkinkan pengguna mengubah informasi barang yang sudah ada.</li>
            </ul>
        </li>
        <li>
            <strong>Delete (Hapus Barang):</strong>
            <ul>
                <li>Bagian "Proses Data" yang di-include dari <code>proses_data.php</code>.</li>
                <li>Memungkinkan pengguna menghapus barang dari inventaris.</li>
            </ul>
        </li>
    </ol>
</div>

<h3>Fitur Tambahan dalam Kode</h3>
    <ul id="fitur">
        <li>Desain responsif dengan CSS</li>
        <li>Tombol untuk menampilkan/menyembunyikan section</li>
        <li>Catatan penting tentang refresh halaman untuk melihat perubahan</li>
    </ul>

<h3>Fungsi JavaScript:</h3>
<div class="container">
        <p>Fungsi-fungsi ini memungkinkan navigasi antarhalaman tanpa me-reload seluruh halaman.</p>
    <h2>Penjelasan Operasi CREATE pada add_data.php</h2>
    <h2>1. Koneksi Database</h2>
    <p>
        Untuk membuat koneksi ke database MySQL, gunakan kode berikut:
    </p>
<img src="code1.png" alt="" width="60%">
<h3>Penjelasan Koneksi Database</h3>
    <ul>
        <li>Membuat koneksi ke database MySQL</li>
        <li>Host: <b>localhost</b></li>
        <li>Username: <b>root</b></li>
        <li>Password: <b>kosong</b></li>
        <li>Nama Database: <b>db.eko</b></li>
    </ul>
    <h3>2. Proses Penambahan Data</h3>
<img src="code2.png" alt="" width="60%">
<h3>Fitur utama:</h3>
<ul>
        <li>Menerima data dari form</li>
        <li>Melakukan insert data ke tabel tbl_ekostock</li>
        <li>Menampilkan pesan sukses/error</li>
    </ul>

    <h3>3. Desain Antarmuka Form</h3>
<h3>Fitur form:</h3>
<ul>
        <li>Input untuk ID Barang</li>
        <li>Input untuk Nama Barang</li>
        <li>Input untuk Stok</li>
        <li>Input untuk Harga Beli</li>
        <li>Input untuk Harga jual</li>
    </ul>

    <h3>4. Fitur JavaScript Tambahan</h3>
    <img src="code3.png" alt="" width="60%">
    <h3>Keunggulan:</h3>
    <ul>
        <li>Menambah data tanpa reload halaman (AJAX)</li>
        <li>Mereset form setelah submit</li>
        <li>Menampilkan pesan sukses</li>

    </ul>

    <h2>Penjelasan Operasi UPDATE dalam File Edit Data</h2>
    <h3>1. Proses Pengambilan Data Barang</h3>
    <img src="code4.png" alt="" width="60%">
    <h3>Fitur utana:</h3>
    <ul>
        <li>Mengambil ID barang dari parameter URL</li>
        <li>Menggunakan prepared statement untuk keamanan</li>
        <li>Mengambil data barang berdasarkan ID</li>
        <li>Mencegah SQL Injection</li>
    </ul>

    <h3>2. Form Edit Data</h3>
    <h3>Fitur utana:</h3>
    <ul>
        <li>Input tersembunyi untuk ID Barang</li>
        <li>Menginput Nama Barang</li>
        <li>Input Stok</li>
        <li>Input Harga Beli</li>
        <li>Input Harga Jual</li>
        <li>Tombol Update</li>
    </ul>

    <h3>3. Proses Update</h3>
    <img src="code5.png" alt="" width="60%">
    <ul>
        <li>Form diarahkan ke proses_data.php</li>
        <li>Mengirim data dengan metode POST</li>
        <li>Menyertakan ID Barang tersembunyi</li>
    </ul>

    <h2>3. Fitur JavaScript</h2>
    <h3>Fitur hapus barang</h3>
<img src="code6.png" alt="" width="60%">
<h3>Keunggulan</h3>
    <ul>
        <li>Konfirmasi sebelum menghapus</li>
        <li>Pengiriman data secara asynchronous</li>
        <li>Penghapusan baris tanpa reload halaman</li>
    </ul>
    <h2>Fungsi Edit Barang</h2>
    <img src="code7.png" alt="" width="60%">
    <ul>
        <li>Membuka form edit di iframe</li>
        <li>Menampilkan section edit</li>
    </ul>

    <h2>4. Penanganan Kondisi Kosong</h2>
<h3>Fitur Utama:</h3>
    <ul>
        <li>Menampilkan pesan jika tidak ada data</li>
    </ul>
</body>
</html>