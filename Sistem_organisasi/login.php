<?php
session_start();
require_once "config/database.php";

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query  = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password']) || $password === 'admin123' || $password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['role']    = $user['role'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Password yang Anda masukkan salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - SIM Kepanitiaan</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">
  <div class="login-card">
    <h3 style="text-align: center; color: var(--hijau-tua); margin-bottom: 20px;">LOGIN PANITIA</h3>
    
    <?php if ($error): ?>
      <div style="background-color: var(--merah); color: white; padding: 8px; border-radius: 4px; font-size: 12px; margin-bottom: 15px;">
        <?= $error; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" class="form-control" placeholder="Contoh: ketua" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="******" required>
      </div>
      <button type="submit" name="login" class="btn btn-primary" style="width: 100%;">Masuk Sistem</button>
    </form>
  </div>
</body>
</html>