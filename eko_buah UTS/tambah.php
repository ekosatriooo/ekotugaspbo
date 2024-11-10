<?php
require 'database.php';

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    
    // cek data apakah berhasil ditambahkan atau tidak
   if ( tambah($_POST) > 0 ) {
    echo "
    <script>
    alert('data berhasil ditambahkan!');
    document.location.href = 'index.php';
    </script>
    ";
   } else {
    echo "
    <script>
    alert('data gagal ditambahkan!');
    document.location.href = 'index.php';
    </script>";
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Barang</title>

    <!-- CSS for styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        h1 {
            text-align: center;
            margin-top: 50px;
            color: #333;
        }

        form {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        form ul {
            list-style-type: none;
            padding: 0;
        }

        form li {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        button:active {
            background-color: #388e3c;
        }
    </style>
</head>
<body>
    <h1>Tambah Data Barang</h1>

    <form action="" method="post">
        <ul>
            <li>
                <label for="nama_barang">Nama Barang: </label>
                <input type="text" name="nama_barang" id="nama_barang" required>
            </li>
            <li>
                <label for="stok">Stok: </label>
                <input type="number" name="stok" id="stok">
            </li>
            <li>
                <label for="harga_beli">Harga Beli: </label>
                <input type="number" name="harga_beli" id="harga_beli">
            </li>
            <li>
                <label for="harga_jual">Harga Jual: </label>
                <input type="number" name="harga_jual" id="harga_jual">
            </li>
            <li><button type="submit" name="submit">Tambah Data!</button></li>
        </ul>
    </form>
</body>
</html>
