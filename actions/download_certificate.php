<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php?error=Silakan login sebagai user terlebih dahulu');
    exit;
}

require_once __DIR__ . '/../config/database.php';

$userId = (int) $_SESSION['user_id'];
$certificateId = (int) ($_GET['id'] ?? 0);

if ($certificateId <= 0) {
    header('Location: ../user/status_sertifikat.php?error=Sertifikat tidak valid');
    exit;
}

$stmt = $pdo->prepare(
    "SELECT s.id, s.certificate_id, s.certificate_file, s.status, s.signature_verified
     FROM sertifikat s
     JOIN peserta p ON p.id = s.peserta_id
     WHERE s.id = ? AND p.user_id = ?
     LIMIT 1"
);
$stmt->execute([$certificateId, $userId]);
$certificate = $stmt->fetch();

if (!$certificate) {
    header('Location: ../user/status_sertifikat.php?error=Sertifikat tidak ditemukan');
    exit;
}

$isAccepted = (int) $certificate['signature_verified'] === 1 && in_array($certificate['status'], ['ditandatangani', 'terkirim'], true);
if (!$isAccepted) {
    header('Location: ../user/status_sertifikat.php?error=Sertifikat belum diterima oleh admin');
    exit;
}

$relativeFile = trim((string) ($certificate['certificate_file'] ?? ''));
if ($relativeFile === '') {
    header('Location: ../user/status_sertifikat.php?error=File sertifikat belum tersedia');
    exit;
}

$baseDir = realpath(__DIR__ . '/..');
$allowedDir = realpath($baseDir . '/uploads/certificates');
$filePath = realpath($baseDir . '/' . $relativeFile);

if (!$baseDir || !$allowedDir || !$filePath || !is_file($filePath)) {
    header('Location: ../user/status_sertifikat.php?error=File sertifikat tidak ditemukan di server');
    exit;
}

$allowedPrefix = $allowedDir . DIRECTORY_SEPARATOR;
if (strpos($filePath, $allowedPrefix) !== 0) {
    header('Location: ../user/status_sertifikat.php?error=Akses file sertifikat tidak valid');
    exit;
}

$downloadName = preg_replace('/[^A-Za-z0-9_-]/', '_', $certificate['certificate_id']) . '.pdf';

if (ob_get_length()) {
    ob_end_clean();
}

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $downloadName . '"');
header('Content-Length: ' . filesize($filePath));
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
readfile($filePath);
exit;
