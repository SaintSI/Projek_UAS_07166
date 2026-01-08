<?php
include 'koneksi.php';

$kode       = $_POST['kode_barang'];
$nama       = $_POST['nama_barang'];
$kategori   = $_POST['kategori'];
$tgl        = $_POST['tgl_beli'];
$kondisi    = $_POST['kondisi'];
$deskripsi  = $_POST['deskripsi'];

$nama_foto = "";

if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $file_tmp   = $_FILES['foto']['tmp_name'];
    $nama_asli  = $_FILES['foto']['name'];
    $ekstensi   = strtolower(pathinfo($nama_asli, PATHINFO_EXTENSION));
    
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($ekstensi, $allowed)) {
        echo "<script>
                alert('Format file tidak valid! Harap upload JPG atau PNG.');
                window.history.back();
              </script>";
        exit;
    }

    $nama_foto = uniqid() . "." . $ekstensi;
    $folder_tujuan = "uploads/";

    if (!is_dir($folder_tujuan)) {
        mkdir($folder_tujuan, 0777, true);
    }

    if (!move_uploaded_file($file_tmp, $folder_tujuan . $nama_foto)) {
        echo "<script>
                alert('Gagal mengupload foto! Pastikan folder uploads ada.');
                window.history.back();
              </script>";
        exit;
    }
}

$sql = "INSERT INTO barang (kode_barang, nama_barang, kategori, tgl_beli, kondisi, deskripsi, foto) 
        VALUES ('$kode', '$nama', '$kategori', '$tgl', '$kondisi', '$deskripsi', '$nama_foto')";

if (mysqli_query($conn, $sql)) {
    // SUKSES
    echo "<script>
            alert('Data Berhasil Disimpan!');
            window.location.href = 'tampilInventaris.php';
          </script>";
} else {
    // GAGAL
    echo "<script>
            alert('Gagal menyimpan data: " . mysqli_error($conn) . "');
            window.history.back();
          </script>";
}
?>