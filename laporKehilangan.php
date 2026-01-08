<?php
session_start();
include 'koneksi.php';
$id_barang = $_GET['id'];  
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Lapor Kehilangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-danger bg-opacity-10 d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 shadow-sm border-danger" style="width: 500px;">
    <h4 class="mb-4 fw-bold text-danger">⚠️ Lapor Kehilangan Barang</h4>
    <p class="text-muted small">Barang yang dilaporkan hilang akan statusnya berubah permanen.</p>
    
    <form action="simpanKehilangan.php" method="POST">
        <input type="hidden" name="id_barang" value="<?= $id_barang ?>">
        
        <div class="mb-3">
            <label class="form-label">Tanggal Hilang/Diketahui</label>
            <input type="date" name="tgl_hilang" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Pelapor</label>
            <input type="text" name="pelapor" class="form-control" placeholder="Misal: Kepala Lab" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kronologi / Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" required placeholder="Jelaskan bagaimana barang bisa hilang..."></textarea>
        </div>

        <button type="submit" class="btn btn-danger w-100">Konfirmasi Barang Hilang</button>
        <a href="tampilInventaris.php" class="btn btn-link w-100 text-decoration-none mt-2 text-muted">Batal</a>
    </form>
</div>

</body>
</html>