<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header('Location: ../login.php?error=Username dan password wajib diisi');
    exit;
}

$stmt = $pdo->prepare(
    'SELECT id, username, password_hash
     FROM admins
     WHERE username = ?
     LIMIT 1'
);

$stmt->execute([$username]);

$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin && password_verify($password, $admin['password_hash'])) {
    session_regenerate_id(true);

    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_username'] = $admin['username'];

    header('Location: ../admin/dashboard.php');
    exit;
}

header('Location: ../login.php?error=Username atau password salah');
exit;
