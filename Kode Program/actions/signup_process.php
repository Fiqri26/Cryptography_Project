<?php
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../signup.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';
$fullName = trim($_POST['full_name'] ?? '');

if ($username === '' || $password === '' || $confirmPassword === '') {
    header('Location: ../signup.php?error=Semua field wajib diisi');
    exit;
}

if ($password !== $confirmPassword) {
    header('Location: ../signup.php?error=Konfirmasi password tidak sama');
    exit;
}

$stmt = $pdo->prepare('SELECT id FROM admins WHERE username = ? LIMIT 1');
$stmt->execute([$username]);
if ($stmt->fetch()) {
    header('Location: ../signup.php?error=Username sudah digunakan');
    exit;
}

$stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
$stmt->execute([$username]);
if ($stmt->fetch()) {
    header('Location: ../signup.php?error=Username sudah digunakan');
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
$fullName = $fullName !== '' ? $fullName : $username;
$stmt = $pdo->prepare('INSERT INTO users (full_name, username, email, password_hash) VALUES (?, ?, ?, ?)');
$stmt->execute([$fullName, $username, '', $passwordHash]);

header('Location: ../login.php?success=Akun user berhasil dibuat. Silakan login.');
exit;
