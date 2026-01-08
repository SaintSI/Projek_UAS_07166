<?php
include 'koneksi.php';

$id = $_GET['id'];

$sql = "SELECT * FROM barang WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Aset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; }
        .form-card { background: white; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); max-width: 800px; margin: 50px auto; border:none; }
        .form-header { background: linear-gradient(135deg, #f59e0b, #d97706); padding: 30px; color: white; }
        .form-body { padding: 40px; }
        .form-label { font-weight: 600; color: #334155; font-size: 0.9rem; margin-bottom: 8px; }
        .form-control, .form-select { border-radius: 8px; padding: 12px; border: 1px solid #e2e8f0; background-color: #f8fafc; }
        .form-control:focus { background-color: white; border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1); }
        .btn-update { background-color: #f59e0b; color: white; padding: 12px 30px; border-radius: 8px; font-weight: 600; border: none; transition: 0.3s; }
        .btn-update:hover { background-color: #d97706; transform: translateY(-2px); }
        .img-preview { width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 2px dashed #cbd5e1; padding: 2px; }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-card">
            <div class="form-header">
                <h4 class="mb-0 fw-bold">Edit Data Aset</h4>
                <p class="mb-0 opacity-75 small">Perbarui informasi barang inventaris</p>
            </div>
            
            <div class="form-body">
                <form action="simpanKoreksiInventaris.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" name="kode_barang" class="form-control" value="<?= $data['kode_barang'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" value="<?= $data['nama_barang'] ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="Komputer" <?= ($data['kategori'] == 'Komputer') ? 'selected' : '' ?>>Komputer / PC</option>
                                <option value="Monitor" <?= ($data['kategori'] == 'Monitor') ? 'selected' : '' ?>>Monitor</option>
                                <option value="Peripherals" <?= ($data['kategori'] == 'Peripherals') ? 'selected' : '' ?>>Aksesoris</option>
                                <option value="Jaringan" <?= ($data['kategori'] == 'Jaringan') ? 'selected' : '' ?>>Jaringan</option>
                                <option value="Furniture" <?= ($data['kategori'] == 'Furniture') ? 'selected' : '' ?>>Furniture</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pembelian</label>
                            <input type="date" name="tgl_beli" class="form-control" value="<?= $data['tgl_beli'] ?>" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label d-block">Kondisi</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="kondisi" id="baik" value="Baik" <?= ($data['kondisi'] == 'Baik') ? 'checked' : '' ?>>
                                <label class="btn btn-outline-success" for="baik">✅ Baik</label>

                                <input type="radio" class="btn-check" name="kondisi" id="rusak_ringan" value="Rusak Ringan" <?= ($data['kondisi'] == 'Rusak Ringan') ? 'checked' : '' ?>>
                                <label class="btn btn-outline-warning" for="rusak_ringan">⚠️ Rusak Ringan</label>

                                <input type="radio" class="btn-check" name="kondisi" id="rusak_berat" value="Rusak Berat" <?= ($data['kondisi'] == 'Rusak Berat') ? 'checked' : '' ?>>
                                <label class="btn btn-outline-danger" for="rusak_berat">❌ Rusak Berat</label>
                            </div>
                        </div>

                        <div class="col-12 d-flex align-items-center gap-4">
                            <div>
                                <label class="form-label d-block">Foto Saat Ini</label>
                                <?php
                                    $fotoPath = "uploads/" . $data['foto'];
                                    if(!empty($data['foto']) && file_exists($fotoPath)){
                                        echo "<img src='$fotoPath' class='img-preview'>";
                                    } else {
                                        echo "<div class='img-preview d-flex align-items-center justify-content-center text-muted small'>No Image</div>";
                                    }
                                ?>
                            </div>
                            <div class="flex-grow-1">
                                <label class="form-label">Ganti Foto (Opsional)</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                <input type="hidden" name="foto_lama" value="<?= $data['foto'] ?>">
                                <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto.</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"><?= $data['deskripsi'] ?></textarea>
                        </div>

                        <div class="col-12 d-flex justify-content-between align-items-center mt-4">
                            <a href="tampilInventaris.php" class="text-decoration-none text-muted fw-bold">← Batal</a>
                            <button type="submit" class="btn-update">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>