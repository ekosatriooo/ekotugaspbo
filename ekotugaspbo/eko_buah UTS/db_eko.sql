-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2024 at 03:59 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_eko`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_ekostok`
--

CREATE TABLE `tb_ekostok` (
  `id_barang` int(12) NOT NULL,
  `nama_barang` varchar(225) NOT NULL,
  `stok` int(12) NOT NULL,
  `harga_beli` int(12) NOT NULL,
  `harga_jual` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_ekostok`
--

INSERT INTO `tb_ekostok` (`id_barang`, `nama_barang`, `stok`, `harga_beli`, `harga_jual`) VALUES
(1, 'Apel', 10, 1000, 2000),
(2, 'Mangga', 20, 3000, 4000),
(3, 'Nanas', 30, 5000, 6000),
(4, 'Pisang', 40, 7000, 8000),
(5, 'Pepaya', 50, 9000, 10000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_ekostok`
--
ALTER TABLE `tb_ekostok`
  ADD PRIMARY KEY (`id_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
