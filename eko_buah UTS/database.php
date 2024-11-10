<?php
$conn = mysqli_connect("localhost", "root", "", "db_eko");
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function tambah($data) {
    global $conn;
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $stok = htmlspecialchars($data["stok"]);
    $harga_beli = htmlspecialchars($data["harga_beli"]);
    $harga_jual = htmlspecialchars($data["harga_jual"]);

     
     $query = "INSERT INTO tb_ekostok
     VALUES('', '$nama_barang', '$stok', '$harga_beli', '$harga_jual')";
     mysqli_query($conn, $query);

     return mysqli_affected_rows($conn);
}
function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM tb_ekostok WHERE id_barang = $id");

    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;
    $id = $data["id_barang"];
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $stok = htmlspecialchars($data["stok"]);
    $harga_beli = htmlspecialchars($data["harga_beli"]);
    $harga_jual = htmlspecialchars($data["harga_jual"]);

     
     $query = "UPDATE tb_ekostok SET
                nama_barang= '$nama_barang',
                stok= '$stok',
                harga_beli= '$harga_beli',
                harga_jual= '$harga_jual'
                WHERE id_barang = $id";
     mysqli_query($conn, $query);

     return mysqli_affected_rows($conn);
}


function cari($keyword) {
    $query = "SELECT * FROM tb_ekostok
                WHERE
                nama_barang LIKE '%$keyword%' OR
                stok LIKE '%$keyword%' OR
                harga_beli LIKE '%$keyword%' OR
                harga_jual LIKE '%$keyword%'
                ";
        return query($query);
}
?>
