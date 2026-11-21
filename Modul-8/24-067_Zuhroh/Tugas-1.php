<?php
require 'koneksi.php';

if (isset($_SESSION['id_user'])) {
    header('Location: Tugas-2.php');
    exit;
}

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $stmt = mysqli_prepare($koneksi, "SELECT id_user, nama, username, password, level FROM user WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if ($row && password_verify($password, $row['password'])) {
            session_regenerate_id(true);
            // set session
            $_SESSION['id_user']  = $row['id_user'];
            $_SESSION['nama']     = $row['nama'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['level']    = (int)$row['level'];
            header('Location: Tugas-2.php');
            exit;
        } else {
            $error = 'Username atau password salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - Sistem Penjualan</title>
<style>
  body{font-family:Arial,sans-serif;background:#eef2f7;display:flex;justify-content:center;align-items:center;height:100vh;margin:0}
  .box{background:#fff;padding:30px;border-radius:8px;width:320px;box-shadow:0 2px 10px rgba(0,0,0,.15)}
  h2{margin-top:0;text-align:center;color:#1a4a8a}
  label{font-size:14px}
  input{width:100%;padding:9px;margin:6px 0 14px;box-sizing:border-box;border:1px solid #bbb;border-radius:4px}
  button{width:100%;padding:10px;background:#1a4a8a;color:#fff;border:0;border-radius:4px;cursor:pointer}
  .error{background:#fde8e8;color:#b00020;padding:8px;border-radius:4px;margin-bottom:12px;font-size:14px}
</style>
</head>
<body>
<div class="box">
  <h2>Sistem Penjualan</h2>
  <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="post" autocomplete="off">
    <label>Username</label>
    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" autofocus>
    <label>Password</label>
    <input type="password" name="password">
    <button type="submit">Login</button>
  </form>
</div>
</body>
</html>
