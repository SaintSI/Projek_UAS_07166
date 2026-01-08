<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// --- LOGIKA STATISTIK ---
$q1 = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE status = 'Dipinjam'");
$dipinjam = mysqli_fetch_assoc($q1)['total'];

$q2 = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE status = 'Kembali'");
$dikembalikan = mysqli_fetch_assoc($q2)['total'];

$q3 = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE status = 'Dipinjam' AND DATEDIFF(CURDATE(), tgl_pinjam) > 7");
$terlambat = mysqli_fetch_assoc($q3)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sirkulasi Peminjaman - LabTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; }
        
        .navbar { background-color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 1rem 0; }
        .navbar-brand { font-weight: 700; color: #2563eb !important; font-size: 1.25rem; }

        .stat-card {
            border: none; border-radius: 16px; padding: 25px; position: relative; overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); color: white; height: 100%;
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-5px); }

        .bg-blue-gradient { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .bg-green-gradient { background: linear-gradient(135deg, #10b981, #059669); }
        .bg-red-gradient { background: linear-gradient(135deg, #ef4444, #dc2626); }
        
        .icon-overlay { position: absolute; right: -10px; bottom: -10px; font-size: 4rem; opacity: 0.2; transform: rotate(-15deg); }

        .table-card { border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .nav-tabs .nav-link { color: #64748b; font-weight: 600; padding: 12px 20px; border: none; }
        .nav-tabs .nav-link.active { color: #2563eb; border-bottom: 3px solid #2563eb; background: transparent; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="tampilInventaris.php">🖥️ LabTrack.</a>
        <div class="d-flex gap-2">
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark">Peminjaman Barang</h2>
            <p class="text-muted mb-0">Kelola sirkulasi barang masuk dan keluar.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="tampilInventaris.php" class="btn btn-outline-secondary rounded-pill me-2 px-3">← Kembali ke Inventaris</a>
            <a href="tambahPeminjaman.php" class="btn btn-primary rounded-pill px-4 shadow-sm">+ Catat Peminjaman</a>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card bg-blue-gradient">
                <div class="position-relative z-1">
                    <h6 class="mb-2 opacity-75">Sedang Dipinjam</h6>
                    <h2 class="fw-bold mb-0"><?= $dipinjam ?> <span class="fs-6 fw-normal">Unit</span></h2>
                </div>
                <div class="icon-overlay">⏳</div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stat-card bg-red-gradient">
                <div class="position-relative z-1">
                    <h6 class="mb-2 opacity-75">Terlambat (> 7 Hari)</h6>
                    <h2 class="fw-bold mb-0"><?= $terlambat ?> <span class="fs-6 fw-normal">Unit</span></h2>
                </div>
                <div class="icon-overlay">⚠️</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card bg-green-gradient">
                <div class="position-relative z-1">
                    <h6 class="mb-2 opacity-75">Riwayat Kembali</h6>
                    <h2 class="fw-bold mb-0"><?= $dikembalikan ?> <span class="fs-6 fw-normal">Selesai</span></h2>
                </div>
                <div class="icon-overlay">✅</div>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-4 shadow-sm table-card">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="aktif-tab" data-bs-toggle="tab" data-bs-target="#aktif" type="button">📋 Sedang Dipinjam</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button">📜 Riwayat Pengembalian</button>
            </li>
        </ul>

        <div class="tab-content mt-4" id="myTabContent">
            
            <div class="tab-pane fade show active" id="aktif">
                <table id="tableAktif" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Barang</th>
                            <th>Peminjam</th>
                            <th>Tgl Pinjam</th>
                            <th>Durasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT p.*, b.nama_barang, b.kode_barang 
                                FROM peminjaman p 
                                JOIN barang b ON p.id_barang = b.id 
                                WHERE p.status = 'Dipinjam'
                                ORDER BY p.tgl_pinjam DESC";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $tgl_pinjam = new DateTime($row['tgl_pinjam']);
                            $hari_ini   = new DateTime();
                            $selisih    = $hari_ini->diff($tgl_pinjam);
                            $durasi     = $selisih->days;

                            $badge_durasi = ($durasi > 7) 
                                ? "<span class='badge bg-danger'>$durasi Hari (Telat)</span>" 
                                : "<span class='badge bg-info text-dark'>$durasi Hari</span>";

                            echo "<tr>
                                <td>
                                    <div class='fw-bold'>{$row['nama_barang']}</div>
                                    <div class='text-muted small'>{$row['kode_barang']}</div>
                                </td>
                                <td>{$row['nama_peminjam']}</td>
                                <td>{$row['tgl_pinjam']}</td>
                                <td>$badge_durasi</td>
                                <td>
                                    <a href='kembaliBarang.php?id={$row['id']}&id_barang={$row['id_barang']}' 
                                       class='btn btn-success btn-sm rounded-pill px-3'
                                       onclick=\"return confirm('Barang sudah kembali?')\">✅ Selesai</a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="riwayat">
                <table id="tableRiwayat" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Barang</th>
                            <th>Peminjam</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT p.*, b.nama_barang, b.kode_barang 
                                FROM peminjaman p 
                                JOIN barang b ON p.id_barang = b.id 
                                WHERE p.status = 'Kembali'
                                ORDER BY p.tgl_kembali DESC";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                <td>
                                    <div class='fw-bold'>{$row['nama_barang']}</div>
                                    <div class='text-muted small'>{$row['kode_barang']}</div>
                                </td>
                                <td>{$row['nama_peminjam']}</td>
                                <td>{$row['tgl_pinjam']}</td>
                                <td>{$row['tgl_kembali']}</td>
                                <td><span class='badge bg-secondary'>Selesai</span></td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#tableAktif').DataTable();
        $('#tableRiwayat').DataTable();
    });
</script>

</body>
</html>