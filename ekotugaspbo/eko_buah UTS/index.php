<?php
require 'database.php';
$tb_ekostok = query("SELECT * FROM tb_ekostok");

if( isset($_POST["cari"])) {
    $tb_ekostok = cari($_POST["keyword"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOKO BUAH EKO</title>
    <style>
        /* Basic Page Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
            color: Black;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 12px;
            font-size: 18px;
            width: 350px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button[type="submit"] {
            padding: 12px 20px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Button Styles for "Tambah data barang" */
        .btn-tambah {
            display: block;
            width: 220px;
            margin: 20px auto;
            padding: 12px 20px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 18px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-tambah:hover {
            background-color: #45a049;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Table Styles */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-size: 18px;
        }

        td {
            background-color: #fff;
            font-size: 16px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Button Styles for "hapus" and "ubah" */
        .btn-ubah, .btn-delete {
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-ubah {
            background-color: #FFD700;
            color: #000;
            transition: background-color 0.3s ease;
        }

        .btn-ubah:hover {
            background-color: #FFCC00;
        }

        .btn-delete {
            background-color: #FF6347; /* Tomato Red */
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #FF4500; /* Darker Red */
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            input[type="text"] {
                width: 100%;
                margin-bottom: 10px;
            }

            button[type="submit"] {
                width: 100%;
            }

            table {
                font-size: 14px;
            }

            .btn-tambah {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <h1>TOKO BUAH EKO</h1>
    <br><br>
    <h2>TUGAS UTS</h2>

    <form action="" method="post">
        <input type="text" name="keyword" size="30" autofocus placeholder="Cari" autocomplete="off">
        <button type="submit" name="cari">Cari!</button>
    </form>

    <!-- Tambah Barang Button moved above the table -->
    <a href="tambah.php" class="btn-tambah">Tambah data barang</a>

    <br>
    <table>
        <tr>
            <th>id_barang</th>
            <th>nama_barang</th>
            <th>stok</th>
            <th>harga_beli</th>
            <th>harga_jual</th>
            <th>Actions</th>
        </tr>

        <?php $i = 1; ?>
        <?php foreach( $tb_ekostok as $row) :?>
        <tr>
            <td><?= $i; ?></td>
            <td><?= $row["nama_barang"]; ?></td>
            <td><?= $row["stok"]; ?></td>
            <td><?= $row["harga_beli"]; ?></td>
            <td><?= $row["harga_jual"]; ?></td>
            <td>
                <a href="ubah.php?id=<?= $row["id_barang"]; ?>" class="btn-ubah">ubah</a>
                <a href="hapus.php?id=<?= $row["id_barang"]; ?>" class="btn-delete" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">hapus</a>
            </td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>

</body>
</html>
