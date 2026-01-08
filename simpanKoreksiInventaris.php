<?php
include 'koneksi.php';

$id = $_POST['id'];
$kode = $_POST['kode_barang'];
$nama = $_POST['nama_barang'];
$kategori = $_POST['kategori'];
$tgl = $_POST['tgl_beli'];
$kondisi = $_POST['kondisi'];
$deskripsi = $_POST['deskripsi'];
$foto_lama = $_POST['foto_lama'];

$nama_foto = $foto_lama; 

if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $file_tmp = $_FILES['foto']['tmp_name'];
    $nama_asli = $_FILES['foto']['name'];
    $ekstensi = strtolower(pathinfo($nama_asli, PATHINFO_EXTENSION));
    
    $nama_foto = uniqid() . "." . $ekstensi;
    move_uploaded_file($file_tmp, "uploads/" . $nama_foto);

    if (file_exists("uploads/" . $foto_lama) && $foto_lama != "") {
        unlink("uploads/" . $foto_lama);
    }
}

$sql = "UPDATE barang SET 
        kode_barang='$kode', 
        nama_barang='$nama', 
        kategori='$kategori', 
        tgl_beli='$tgl', 
        kondisi='$kondisi', 
        deskripsi='$deskripsi', 
        foto='$nama_foto' 
        WHERE id='$id'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data Berhasil Diupdate!'); window.location.href='tampilInventaris.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>