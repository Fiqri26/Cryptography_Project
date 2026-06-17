<?php
require_once __DIR__ . '/includes/functions.php';
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi - Sign Up</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <header class="site-header">
    <nav class="navbar">
      <a href="index.php" class="logo"><span class="logo-mark">✓</span> AsliNi</a>
      <ul class="nav-links">
        <li><a href="index.php">Beranda</a></li>
        <li><a href="verifikasi.php">Verifikasi</a></li>
        <li><a href="developer.php">Developer</a></li>
        <li><a class="active" href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <main class="auth-layout">
    <section class="auth-card">
      <div class="auth-head">
        <div class="auth-check">✓</div>
        <h1>Sign-Up</h1>
        <p>Sistem Sertifikat Digital</p>
      </div>

      <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>

      <form action="actions/signup_process.php" method="POST">
        <div class="form-group">
          <label for="username">Username</label>
          <input class="form-control" type="text" id="username" name="username" placeholder="Masukkan username" required />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input class="form-control" type="password" id="password" name="password" placeholder="Masukkan password" required />
        </div>
        <div class="form-group">
          <label for="confirmPassword">Confirm Password</label>
          <input class="form-control" type="password" id="confirmPassword" name="confirm_password" placeholder="Masukkan password" required />
        </div>
        <button class="btn" type="submit">Daftar</button>
      </form>

      <div class="auth-links">
        <a href="index.php">← Kembali ke Beranda</a>
        <a href="login.php">Sign In</a>
      </div>
    </section>
  </main>
</body>
</html>
