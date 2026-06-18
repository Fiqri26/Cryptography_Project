<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php?error=Silakan login terlebih dahulu');
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';

$stmt = $pdo->prepare('SELECT id, full_name, username, email, phone, role FROM admins WHERE id = ? LIMIT 1');
$stmt->execute([$_SESSION['admin_id']]);
$currentAdmin = $stmt->fetch();

if (!$currentAdmin) {
    session_destroy();
    header('Location: ../login.php?error=Sesi tidak valid, silakan login ulang');
    exit;
}

$currentAdminInitials = adminInitials($currentAdmin['full_name']);
