<?php
session_start();
if (isset($_SESSION['login'])) {
    header("Location: tampilInventaris.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - LabTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
        .login-card {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 400px;
            border: 1px solid #e2e8f0;
        }

        .brand-title {
            color: #2563eb;
            font-weight: 800;
            font-size: 24px;
            margin-bottom: 5px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            font-size: 0.9rem;
        }

        .form-control {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
        }

        .form-control:focus {
            border-color: #2563eb;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-login {
            background-color: #2563eb;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 700;
            width: 100%;
            border: none;
            margin-top: 10px;
            transition: 0.2s;
        }

        .btn-login:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand-title">🖥️ LabTrack.</div>
        <p class="subtitle">Silakan login untuk mengelola inventaris.</p>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            
            <button type="submit" name="btn_login" class="btn-login">Masuk Dashboard</button>
        </form>
            <div style="text-align: center; margin-top: 15px; font-size: 14px; color: #64748b;">
                Belum punya akun? <a href="register.php" style="color: #2563eb; text-decoration: none; font-weight: 600;">Daftar disini</a>
            </div>
    </div>

</body>
</html>

<?php
if (isset($_POST['btn_login'])) {
    require 'koneksi.php';

    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username = '$user'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        if (password_verify($pass, $row['password']) || $pass == $row['password']) {
            $_SESSION['login'] = true;
            $_SESSION['user']  = $row['username'];
            
            echo "<script>
                    alert('Login Berhasil!');
                    document.location.href = 'tampilInventaris.php';
                  </script>";
            exit;
        }
    }
    
    echo "<script>alert('Username atau Password Salah!');</script>";
}
?>