<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_cek = "SELECT foto FROM barang WHERE id='$id'";
    $result = mysqli_query($conn, $sql_cek);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        $foto_path = "uploads/" . $row['foto'];
        if (!empty($row['foto']) && file_exists($foto_path)) {
            unlink($foto_path);
        }
    }

    $sql = "DELETE FROM barang WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Data Berhasil Dihapus!');
                document.location.href = 'tampilInventaris.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data!');
                document.location.href = 'tampilInventaris.php';
              </script>";
    }
} else {
    header("Location: tampilInventaris.php");
}
?>