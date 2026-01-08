<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Aset Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; }
        
        .form-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: none;
            max-width: 800px;
            margin: 50px auto;
            animation: slideUp 0.6s ease-out;
        }

        .form-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            padding: 30px;
            color: white;
        }

        .form-body { padding: 40px; }

        .form-label {
            font-weight: 600;
            color: #334155;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }
        
        .form-control:focus, .form-select:focus {
            background-color: white;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-save {
            background-color: #2563eb;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }
        .btn-save:hover { background-color: #1d4ed8; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-card">
            <div class="form-header">
                <h4 class="mb-0 fw-bold">Tambah Aset Laboratorium</h4>
                <p class="mb-0 opacity-75 small">Masukkan detail barang inventaris baru</p>
            </div>
            
            <div class="form-body">
                <form action="simpanInventaris.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Kode Barang (Inventaris)</label>
                            <input type="text" name="kode_barang" class="form-control" placeholder="Contoh: INV-LAB-001" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Monitor LG 24 Inch" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Komputer">Komputer / PC</option>
                                <option value="Monitor">Monitor</option>
                                <option value="Peripherals">Aksesoris (Mouse/Keyboard)</option>
                                <option value="Jaringan">Perangkat Jaringan</option>
                                <option value="Furniture">Meja/Kursi</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pembelian</label>
                            <input type="date" name="tgl_beli" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label d-block">Kondisi Barang Saat Ini</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="kondisi" id="baik" value="Baik" checked>
                                <label class="btn btn-outline-success" for="baik">✅ Baik</label>

                                <input type="radio" class="btn-check" name="kondisi" id="rusak_ringan" value="Rusak Ringan">
                                <label class="btn btn-outline-warning" for="rusak_ringan">⚠️ Rusak Ringan</label>

                                <input type="radio" class="btn-check" name="kondisi" id="rusak_berat" value="Rusak Berat">
                                <label class="btn btn-outline-danger" for="rusak_berat">❌ Rusak Berat</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Foto Barang</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                            <div class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB.</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi / Spesifikasi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Contoh: Spesifikasi RAM 8GB, SSD 256GB..."></textarea>
                        </div>

                        <div class="col-12 d-flex justify-content-between align-items-center mt-4">
                            <a href="tampilInventaris.php" class="text-decoration-none text-muted fw-bold">← Kembali</a>
                            <button type="submit" class="btn-save">Simpan Data</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>
</html>