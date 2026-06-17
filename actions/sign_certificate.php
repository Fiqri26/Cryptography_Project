<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php?error=Silakan login terlebih dahulu');
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../crypto/generate_key.php';

$id = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: ../admin/signature.php?error=Sertifikat tidak valid');
    exit;
}

$stmt = $pdo->prepare('SELECT id, sha256_hash FROM sertifikat WHERE id = ? LIMIT 1');
$stmt->execute([$id]);
$certificate = $stmt->fetch();

if (!$certificate) {
    header('Location: ../admin/signature.php?error=Sertifikat tidak ditemukan');
    exit;
}

try {
    $signature = aslini_sign_hash($certificate['sha256_hash']);
} catch (Throwable $e) {
    header('Location: ../admin/signature.php?error=' . urlencode($e->getMessage()));
    exit;
}

$stmt = $pdo->prepare('UPDATE sertifikat SET digital_signature = ?, signature_verified = 1, status = ?, signed_at = NOW(), updated_at = NOW() WHERE id = ?');
$stmt->execute([$signature, 'ditandatangani', $id]);

header('Location: ../admin/signature.php?success=Sertifikat berhasil ditandatangani');
exit;
