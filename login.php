<?php
session_start();
// Jika bisa login maka ke index.php
if (isset($_SESSION['login'])) {
    header('location:index.php');
    exit;
}

// Memanggil atau membutuhkan file function.php
require 'function.php';

// jika tombol yang bernama login diklik
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    // password menggunakan md5

    // mengambil data dari user dimana username yg diambil
    $result = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");

    $cek = mysqli_num_rows($result);

    // jika $cek lebih dari 0, maka berhasil login dan masuk ke index.php
    if ($cek > 0) {
        $_SESSION['login'] = true;

        // cek remember me
        if (isset($_POST['remember'])) {
            // buat cookie dan acak cookie

            setcookie('id', $row['id'], time() + 60);

            // mengacak $row dengan algoritma 'sha256'
            setcookie('key', hash('sha256', $row['username']), time() + 60);
        }

        header('location:index.php');
        exit;
    }
    // jika $cek adalah 0 maka tampilkan error
    $error = true;  
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to bottom, #4b3b77, #7f60a8);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background-color: #1e1e2f;
            color: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            width: 100%;
            max-width: 400px;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-login {
            background-color: #007bff;
            color: white;
        }

        .btn-login:hover {
            background-color: #0069d9;
        }

        .btn-signup {
            background-color: #dc3545;
            color: white;
        }

        .btn-signup:hover {
            background-color: #c82333;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="login-card text-center">
        <!-- Logo -->
        <img src="img/Logo login/MA DH NW KALTENG.png" alt="Logo login" class="logo">

        <h4 class="mb-4 fw-bold">SILAKAN LOGIN</h4>

        <!-- Pesan error (jika ada) -->
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger py-2">Username atau Password salah!</div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-3 text-start">
                <input type="text" class="form-control" name="username" placeholder="Masukkan Username" required autofocus>
            </div>
            <div class="mb-4 text-start">
                <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" name="login" class="btn btn-login">Login</button>
                <a href="registrasi.php" class="btn btn-signup">Sign Up</a>
            </div>
        </form>
    </div>

</body>
</html>
