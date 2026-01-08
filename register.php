<?php
require 'koneksi.php';

if (isset($_POST['register'])) {
    $username = strtolower(stripslashes($_POST['username']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm  = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    $cek_user = mysqli_query($conn, "SELECT username FROM admin WHERE username = '$username'");
    if (mysqli_fetch_assoc($cek_user)) {
        echo "<script>alert('Username sudah terdaftar! Pilih yang lain.');</script>";
    } 
    elseif ($password !== $confirm) {
        echo "<script>alert('Konfirmasi password tidak sesuai!');</script>";
    } 
    else {
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO admin (username, password) VALUES ('$username', '$pass_hash')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Registrasi Berhasil! Silakan Login.');
                    document.location.href = 'login.php';
                  </script>";
        } else {
            echo "<script>alert('Gagal Mendaftar!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f1f5f9; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: 'Inter', sans-serif; }
        .card { width: 100%; max-width: 400px; padding: 30px; border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .btn-primary { background: #2563eb; border: none; padding: 12px; font-weight: 600; width: 100%; }
        .btn-primary:hover { background: #1d4ed8; }
        .link { text-decoration: none; color: #2563eb; font-weight: 600; }
    </style>
</head>
<body>

<div class="card">
    <h3 class="text-center fw-bold mb-4" style="color: #2563eb;">Daftar Akun</h3>
    
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Username Baru</label>
            <input type="text" name="username" class="form-control" required placeholder="Buat username...">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Buat password...">
        </div>
        <div class="mb-3">
            <label class="form-label">Ulangi Password</label>
            <input type="password" name="confirm_password" class="form-control" required placeholder="Ketik ulang password...">
        </div>
        
        <button type="submit" name="register" class="btn btn-primary">Daftar Sekarang</button>
    </form>
    
    <p class="text-center mt-3 text-muted" style="font-size: 14px;">
        Sudah punya akun? <a href="login.php" class="link">Login disini</a>
    </p>
</div>

</body>
</html>