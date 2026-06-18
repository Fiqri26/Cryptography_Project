<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php?error=Silakan login terlebih dahulu');
    exit;
}

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/profil.php');
    exit;
}

$adminId = (int) $_SESSION['admin_id'];
$fullName = trim($_POST['full_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$newPassword = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if ($fullName === '' || $username === '') {
    header('Location: ../admin/profil.php?error=Nama lengkap dan username wajib diisi');
    exit;
}

if ($newPassword !== '' && $newPassword !== $confirmPassword) {
    header('Location: ../admin/profil.php?error=Konfirmasi password tidak sama');
    exit;
}

$stmt = $pdo->prepare('SELECT id FROM admins WHERE username = ? AND id <> ? LIMIT 1');
$stmt->execute([$username, $adminId]);
if ($stmt->fetch()) {
    header('Location: ../admin/profil.php?error=Username sudah digunakan admin lain');
    exit;
}

if ($newPassword !== '') {
    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('UPDATE admins SET full_name = ?, username = ?, email = ?, phone = ?, password_hash = ? WHERE id = ?');
    $stmt->execute([$fullName, $username, $email, $phone, $passwordHash, $adminId]);
} else {
    $stmt = $pdo->prepare('UPDATE admins SET full_name = ?, username = ?, email = ?, phone = ? WHERE id = ?');
    $stmt->execute([$fullName, $username, $email, $phone, $adminId]);
}

$_SESSION['admin_username'] = $username;
header('Location: ../admin/profil.php?success=Profil berhasil diperbarui');
exit;
