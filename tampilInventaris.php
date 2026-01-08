<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// --- LOGIKA STATISTIK ---
$q1 = mysqli_query($conn, "SELECT COUNT(*) as total FROM barang");
$total_aset = mysqli_fetch_assoc($q1)['total'];

$q2 = mysqli_query($conn, "SELECT COUNT(*) as baik FROM barang WHERE kondisi = 'Baik'");
$baik = mysqli_fetch_assoc($q2)['baik'];

$q3 = mysqli_query($conn, "SELECT COUNT(*) as ringan FROM barang WHERE kondisi = 'Rusak Ringan'");
$rusak_ringan = mysqli_fetch_assoc($q3)['ringan'];

$q4 = mysqli_query($conn, "SELECT COUNT(*) as berat FROM barang WHERE kondisi = 'Rusak Berat'");
$rusak_berat = mysqli_fetch_assoc($q4)['berat'];

$total_rusak = $rusak_ringan + $rusak_berat;

$q5 = mysqli_query($conn, "SELECT COUNT(*) as hilang FROM barang WHERE kondisi = 'Hilang'");
$hilang = mysqli_fetch_assoc($q5)['hilang'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Inventaris - LabTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        :root { --primary-color: #2563eb; --bg-light: #f8fafc; --text-dark: #1e293b; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-light); color: var(--text-dark); }

        .navbar { background-color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 1rem 0; }
        .navbar-brand { font-weight: 700; color: var(--primary-color) !important; font-size: 1.25rem; }

        .chart-card {
            background: white; border-radius: 16px; padding: 25px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); height: 100%;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
        }

        .mini-stat {
            background: white; border-radius: 12px; padding: 15px 20px;
            border: 1px solid #e2e8f0; margin-bottom: 12px;
            display: flex; align-items: center; justify-content: space-between;
            transition: 0.2s;
        }
        .mini-stat:hover { transform: translateX(5px); border-color: #cbd5e1; }
        .mini-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
        }

        .table-container {
            background: white; border-radius: 16px; padding: 25px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin-top: 20px;
        }
        .img-thumb { width: 40px; height: 40px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; }
        
        .badge-status { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.3px; }
        
        .bg-status-baik { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; } 
        .bg-status-rusak-ringan { background: #ffedd5; color: #9a3412; border: 1px solid #fed7aa; } 
        .bg-status-rusak-berat { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; } 
        .bg-status-hilang { background: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; } 
        
        .btn-action { width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; border: none; transition: 0.2s; }
        .btn-action:hover { opacity: 0.8; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">🖥️ LabTrack.</a>
        <div class="d-flex gap-2">
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    
    <div class="row mb-4 align-items-center">
        <div class="col-md-5">
            <h2 class="fw-bold text-dark">Inventaris Laboratorium</h2>
            <p class="text-muted mb-0">Kelola aset komputer dan peralatan lab.</p>
        </div>
        <div class="col-md-7 text-md-end mt-3 mt-md-0">
            <a href="tampilPeminjaman.php" class="btn btn-warning rounded-pill px-3 me-2 text-white shadow-sm">📋 Data Peminjaman</a>
            <a href="cetakInventaris.php" target="_blank" class="btn btn-outline-secondary rounded-pill me-2">🖨️ Cetak</a>
            <a href="tambahInventaris.php" class="btn btn-primary rounded-pill px-4 shadow-sm">+ Tambah Barang</a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        
        <div class="col-lg-5">
            <div class="chart-card">
                <h6 class="fw-bold text-muted mb-3">Komposisi Kondisi Aset</h6>
                <div style="height: 220px; width: 100%;">
                    <canvas id="inventoryChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="row">
                <div class="col-md-6">
                    <div class="mini-stat">
                        <div>
                            <h6 class="text-muted mb-1 small">Total Aset</h6>
                            <h3 class="fw-bold mb-0"><?= $total_aset ?> <small class="fs-6 text-muted">Unit</small></h3>
                        </div>
                        <div class="mini-icon" style="background: #eff6ff; color: #2563eb;">📦</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mini-stat">
                        <div>
                            <h6 class="text-muted mb-1 small">Kondisi Baik</h6>
                            <h3 class="fw-bold mb-0 text-success"><?= $baik ?> <small class="fs-6 text-muted">Unit</small></h3>
                        </div>
                        <div class="mini-icon" style="background: #dcfce7; color: #16a34a;">✅</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mini-stat">
                        <div>
                            <h6 class="text-muted mb-1 small">Perlu Perbaikan</h6>
                            <h3 class="fw-bold mb-0 text-danger"><?= $total_rusak ?> <small class="fs-6 text-muted">Unit</small></h3>
                        </div>
                        <div class="mini-icon" style="background: #fee2e2; color: #dc2626;">⚠️</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mini-stat mb-0">
                        <div>
                            <h6 class="text-muted mb-1 small">Barang Hilang</h6>
                            <h3 class="fw-bold mb-0 text-purple" style="color: #7e22ce;"><?= $hilang ?> <small class="fs-6 text-muted">Unit</small></h3>
                        </div>
                        <div class="mini-icon" style="background: #f3e8ff; color: #7e22ce;">❓</div>
                    </div>
                </div>
            </div>
            
            <div class="mt-2 p-3 rounded-3 bg-light border border-dashed text-center">
                <small class="text-muted">💡 <b>Status:</b> ✅ Baik | 🟠 Rusak Ringan | 🔴 Rusak Berat | ❓ Hilang </small>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table id="myTable" class="table table-hover align-middle w-100">
            <thead class="table-light">
                <tr>
                    <th width="60">Foto</th>
                    <th>Kode & Nama Barang</th>
                    <th>Kategori</th>
                    <th>Tgl Masuk</th>
                    <th>Kondisi</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM barang ORDER BY id DESC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        
                        $kondisi = $row['kondisi'];
                        $badge_class = 'bg-light text-dark'; 

                        if ($kondisi == 'Baik') {
                            $badge_class = 'bg-status-baik';
                        } elseif ($kondisi == 'Rusak Ringan') {
                            $badge_class = 'bg-status-rusak-ringan'; 
                        } elseif ($kondisi == 'Rusak Berat') {
                            $badge_class = 'bg-status-rusak-berat'; 
                        } elseif ($kondisi == 'Hilang') {
                            $badge_class = 'bg-status-hilang'; 
                        }

                        $gambar = "uploads/" . $row['foto'];
                        $img_tag = (file_exists($gambar) && $row['foto']) 
                            ? "<img src='$gambar' class='img-thumb'>" 
                            : "<span class='text-muted small'>No Img</span>";

                        echo "<tr>
                            <td>$img_tag</td>
                            <td>
                                <div class='fw-bold text-dark'>{$row['nama_barang']}</div>
                                <div class='text-muted small'>{$row['kode_barang']}</div>
                            </td>
                            <td><span class='badge bg-light text-dark border'>{$row['kategori']}</span></td>
                            <td class='text-muted small'>{$row['tgl_beli']}</td>
                            <td><span class='badge-status $badge_class'>$kondisi</span></td>
                            <td class='text-end'>
                                <a href='koreksiInventaris.php?id={$row['id']}' class='btn-action me-1' style='background:#eff6ff; color:#3b82f6;' title='Edit'>✏️</a>
                                <a href='hapusInventaris.php?id={$row['id']}' class='btn-action me-1' style='background:#fef2f2; color:#ef4444;' onclick=\"return confirm('Yakin hapus barang ini?')\" title='Hapus'>🗑️</a>
                                <a href='laporKehilangan.php?id={$row['id']}' class='btn-action' style='background:#fff7ed; color:#ea580c;' title='Lapor Hilang'>⚠️</a>
                            </td>
                        </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });

    const ctx = document.getElementById('inventoryChart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang'],
            datasets: [{
                label: 'Jumlah Unit',
                data: [<?= $baik ?>, <?= $rusak_ringan ?>, <?= $rusak_berat ?>, <?= $hilang ?>],
                backgroundColor: [
                    '#16a34a', 
                    '#f97316', 
                    '#dc2626', 
                    '#7e22ce'  
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { usePointStyle: true, font: { size: 10 }, padding: 15 }
                }
            },
            cutout: '70%'
        }
    });
</script>

</body>
</html>