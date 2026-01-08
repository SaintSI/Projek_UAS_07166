<?php
include 'koneksi.php';

$id_pinjam = $_GET['id'];
$id_barang = $_GET['id_barang'];
$tgl_kembali = date('Y-m-d');

$sql1 = "UPDATE peminjaman SET tgl_kembali='$tgl_kembali', status='Kembali' WHERE id='$id_pinjam'";

$sql2 = "UPDATE barang SET kondisi = 'Baik' WHERE id='$id_barang'";

if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
    echo "<script>alert('Barang Telah Dikembalikan!'); document.location.href='tampilPeminjaman.php';</script>";
}
?>