<?php
session_start();
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u = $_POST['username'];
    $p = $_POST['password'];
    if ($u === "gungwah" && $p === "123") {
        $_SESSION['login'] = true;
        header("Location: index.php");
        exit;
    }
    $error = "Username atau password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>
  body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: url('asset/img/barang-bg.png') no-repeat center center fixed;
    background-size: cover;
  }
  .overlay {
    background: rgba(0,0,0,0.5);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .login-box {
    background: white;
    padding: 40px;
    border-radius: 12px;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    text-align: center;
  }
  .login-box h2 {
    margin-bottom: 24px;
    color: #0d47a1;
  }
  .login-box input {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
  }
  .login-box button {
    background: #0d47a1;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 16px;
    width: 100%;
  }
  .login-box button:hover {
    background: #1565c0;
  }
  .error {
    color: #e53935;
    margin-top: 12px;
  }
</style>
</head>
<body>
<div class="overlay">
  <div class="login-box">
    <h2>Login Admin</h2>
    <form method="POST" action="">
      <input type="text" name="username" placeholder="Username" required autofocus>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Masuk</button>
    </form>
    <?php if ($error): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
