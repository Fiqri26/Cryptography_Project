<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php?error=Silakan login sebagai user terlebih dahulu');
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';

$stmt = $pdo->prepare('SELECT id, full_name, username, email, phone, password_hash, profile_photo FROM users WHERE id = ? LIMIT 1');
$stmt->execute([$_SESSION['user_id']]);
$currentUser = $stmt->fetch();

if (!$currentUser) {
    session_destroy();
    header('Location: ../login.php?error=Sesi user tidak valid, silakan login ulang');
    exit;
}

$currentUserInitials = adminInitials($currentUser['full_name'] ?: $currentUser['username']);
