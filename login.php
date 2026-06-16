<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['admin_id'])) {
    header('Location: admin/dashboard.php');
    exit;
}

require_once __DIR__ . '/includes/functions.php';

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsliNi - Login</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<main class="auth-layout">
    <section class="auth-card">

        <div class="auth-head">
            <h1>Admin Login</h1>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error alert-dismissible">
                <span><?= e($error) ?></span>

                <button
                    type="button"
                    class="alert-close"
                    onclick="this.parentElement.remove();"
                >
                    &times;
                </button>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible">
                <span><?= e($success) ?></span>

                <button
                    type="button"
                    class="alert-close"
                    onclick="this.parentElement.remove();"
                >
                    &times;
                </button>
            </div>
        <?php endif; ?>

        <form action="actions/login_process.php" method="POST">

            <div class="form-group">
                <label for="username">Username</label>

                <input
                    class="form-control"
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Masukkan username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    class="form-control"
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >
            </div>

            <button class="btn" type="submit">
                Login
            </button>

        </form>

    </section>
</main>

<script src="assets/js/script.js"></script>

</body>
</html>
