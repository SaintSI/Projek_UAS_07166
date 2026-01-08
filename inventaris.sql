CREATE DATABASE IF NOT EXISTS inventaris;
USE inventaris;

CREATE TABLE `barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `tgl_beli` date NOT NULL,
  `kondisi` varchar(20) NOT NULL,
  `deskripsi` text,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);