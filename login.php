<?php

session_start();
require_once 'config/database.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $query = mysqli_prepare(
        $conn,
        "SELECT * FROM admin WHERE username = ?"
    );

    mysqli_stmt_bind_param(
        $query,
        "s",
        $username
    );

    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);

    if (mysqli_num_rows($result) > 0) {

        $admin = mysqli_fetch_assoc($result);
        if (password_verify($password, $admin['password'])) {

            $_SESSION['admin_id'] = $admin['id_admin'];
            $_SESSION['fullname'] = $admin['fullname'];
            $_SESSION['role'] = $admin['role'];

            header("Location: admin/dashboard.php");
            exit;

        } else {
            $error = "Username atau password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}

?>

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
        <h1>Admin Login</h1>

        <?php if (!empty($error)) : ?>
          <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

      </div>

        <form method="POST">
          <div class="form-group">
            <label for="username">Username</label>
            <input class="form-control" type="text" id="username" name="username" placeholder="Masukkan username" required />
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" id="password" name="password" placeholder="Masukkan password" required />
          </div>
          <button class="btn" type="submit">Login</button>
        </form>

    </section>
  </main>
</body>
</html>
