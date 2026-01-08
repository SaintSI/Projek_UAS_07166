<?php
include 'koneksi.php';

$id_barang = $_POST['id_barang'];
$peminjam  = $_POST['peminjam'];
$tgl       = $_POST['tgl_pinjam'];

$sql1 = "INSERT INTO peminjaman (id_barang, nama_peminjam, tgl_pinjam) VALUES ('$id_barang', '$peminjam', '$tgl')";

$sql2 = "UPDATE barang SET kondisi = 'Dipinjam' WHERE id = '$id_barang'";

if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
    echo "<script>alert('Peminjaman Berhasil!'); document.location.href='tampilPeminjaman.php';</script>";
} else {
    echo "Error";
}
?>