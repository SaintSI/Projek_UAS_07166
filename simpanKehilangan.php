<?php
include 'koneksi.php';

$id_barang = $_POST['id_barang'];
$tgl       = $_POST['tgl_hilang'];
$pelapor   = $_POST['pelapor'];
$ket       = $_POST['keterangan'];

$sql1 = "INSERT INTO kehilangan (id_barang, tgl_hilang, pelapor, keterangan) 
         VALUES ('$id_barang', '$tgl', '$pelapor', '$ket')";

$sql2 = "UPDATE barang SET kondisi = 'Hilang' WHERE id = '$id_barang'";

if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
    echo "<script>
            alert('Laporan Kehilangan Berhasil Disimpan.');
            document.location.href = 'tampilInventaris.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menyimpan laporan: " . mysqli_error($conn) . "');
            window.history.back();
          </script>";
}
?>