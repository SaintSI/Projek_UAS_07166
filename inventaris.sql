-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2026 at 07:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '123'),
(3, 'andi', '$2y$10$R92O7j8mnhb65g1j/b9j6O/KaVyGz3KoWjMpbzQt.zK0z1qPa929C');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `tgl_beli` date NOT NULL,
  `kondisi` varchar(20) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `kategori`, `tgl_beli`, `kondisi`, `deskripsi`, `foto`) VALUES
(4, 'INV-LAB-M02', 'Monitor Xiaomi A27i', 'Monitor', '2024-07-19', 'Rusak Berat', 'Spesifikasi:\r\n- Resolusi: 1920 * 1080.\r\n- Refresh Rate: 100Hz.\r\n- Ukuran Layar: 27\".', '695f19da3d205.jpeg'),
(6, 'INV-LAB-M03', 'Monitor Samsung S24R350', 'Monitor', '2025-07-09', 'Hilang', 'Spesifikasi:\r\n- Panel Type : IPS.\r\n- Panel Resolution : 1920x1080\r\n- Aspect Ratio : 16 : 9.\r\n- Panel Size(Inch) : 24\r\n- Refresh Rate(hz) : 75/100 Hz.', '695f0becc6414.jpeg'),
(7, 'INV-LAB-M04', 'Monitor Samsung S39GD VA FHD', 'Monitor', '2025-06-11', 'Rusak Ringan', 'Spesifikasi:\r\n- Aspect Ratio: 16:9.\r\n- Screen Size (Class): 27.\r\n- Resolution: FHD (1,920 x 1,080).\r\n- Response Time: 4(GTG).\r\n- Refresh Rate: Max 100Hz.', '695f0cd983e18.jpeg'),
(8, 'INV-LAB-M04', 'Monitor Xiaomi Curved Gaming G34WQi', 'Monitor', '2024-06-13', 'Baik', 'Spesifikasi:\r\n- Ukuran Layar: 34\".\r\n- Rasio Aspek: 21:9.\r\n- Resolusi: 3440 x 1440.\r\n- Refresh Rate Maksimal: 180 Hz.\r\n- Berat Bersih Produk (termasuk kaki penyangga): 6,9 kg.', '696491bd0f4f2.jpeg'),
(9, 'INV-LAB-M05', 'Monitor Xiaomi A24i', 'Monitor', '2024-07-18', 'Baik', 'Spesifikasi:\r\n- Aspect Ratio : 16:9.\r\n- Power Input : 12V⎓2A.\r\n- Maximum Resolution : 1920 x 1080.\r\n- Display Size : 23.8\". \r\n- Refresh Rate: 100Hz.', '696493523e98a.jpeg'),
(10, 'INV-LAB-M06', 'Monitor Samsung S24F320', 'Monitor', '2024-07-17', 'Baik', 'Spesifikasi:\r\n- Panel Size(Inch) : 24 Inch.\r\n- Panel Type : IPS Flat.\r\n- Panel Resolution : 1920 x 1080 (FHD).\r\n- Aspect Ratio : 16:9 Wide.\r\n- Refresh Rate(Hz) : 120.\r\n- Response Time(ms) : 5.', '69649648aa469.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `kehilangan`
--

CREATE TABLE `kehilangan` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `tgl_hilang` date NOT NULL,
  `pelapor` varchar(100) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kehilangan`
--

INSERT INTO `kehilangan` (`id`, `id_barang`, `tgl_hilang`, `pelapor`, `keterangan`) VALUES
(1, 3, '2024-10-17', 'Kurniawan', 'Terlupakan '),
(2, 2, '2024-07-17', 'Kurniawan', 'Hilang'),
(3, 6, '2025-10-14', 'Guru Informatika', 'Lupa');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama_peminjam` varchar(100) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status` enum('Dipinjam','Kembali') NOT NULL DEFAULT 'Dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_barang`, `nama_peminjam`, `tgl_pinjam`, `tgl_kembali`, `status`) VALUES
(1, 3, 'Kurniawan', '2024-10-16', '2026-01-05', 'Kembali');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kehilangan`
--
ALTER TABLE `kehilangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kehilangan`
--
ALTER TABLE `kehilangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
