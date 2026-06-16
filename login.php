<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi - Login</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
  <main class="auth-layout">
    <section class="auth-card">
      <div class="auth-head">
        <div class="auth-check">✓</div>
        <h1>Admin Login</h1>
        <p>Sistem Sertifikat Digital</p>
      </div>

        <div class="form-group">
          <label for="username">Username</label>
          <input class="form-control" type="text" id="username" name="username" placeholder="Masukkan username" required />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input class="form-control" type="password" id="password" name="password" placeholder="Masukkan password" required />
        </div>
        <button class="btn" type="submit">Login</button>

        <div class="auth-links">
            <a href="index.php">← Kembali ke Beranda</a>
        </div>

    </section>
  </main>
</body>
</html>
