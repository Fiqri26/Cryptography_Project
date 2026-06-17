<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php?error=Silakan login sebagai user terlebih dahulu');
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../crypto/sha256.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../user/daftar_sertifikat.php');
    exit;
}

$userId = (int) $_SESSION['user_id'];
$namaPeserta = trim($_POST['nama_peserta'] ?? '');
$pelatihan = trim($_POST['pelatihan'] ?? '');

if ($namaPeserta === '' || $pelatihan === '') {
    header('Location: ../user/daftar_sertifikat.php?error=Nama peserta dan pelatihan wajib diisi');
    exit;
}

if (!isset($_FILES['certificate_file']) || $_FILES['certificate_file']['error'] === UPLOAD_ERR_NO_FILE) {
    header('Location: ../user/daftar_sertifikat.php?error=File PDF sertifikat wajib diunggah');
    exit;
}

if ($_FILES['certificate_file']['error'] !== UPLOAD_ERR_OK) {
    header('Location: ../user/daftar_sertifikat.php?error=Gagal mengupload file PDF');
    exit;
}

if ($_FILES['certificate_file']['size'] > 10 * 1024 * 1024) {
    header('Location: ../user/daftar_sertifikat.php?error=Ukuran file PDF maksimal 10MB');
    exit;
}

$mime = mime_content_type($_FILES['certificate_file']['tmp_name']);
$extension = strtolower(pathinfo($_FILES['certificate_file']['name'], PATHINFO_EXTENSION));
if ($mime !== 'application/pdf' && $extension !== 'pdf') {
    header('Location: ../user/daftar_sertifikat.php?error=File harus berformat PDF');
    exit;
}

$stmt = $pdo->prepare('SELECT username, email FROM users WHERE id = ? LIMIT 1');
$stmt->execute([$userId]);
$user = $stmt->fetch();
if (!$user) {
    session_destroy();
    header('Location: ../login.php?error=Sesi user tidak valid, silakan login ulang');
    exit;
}

$uploadDir = __DIR__ . '/../uploads/certificates';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}
$fileName = 'certificate_' . $userId . '_' . time() . '.pdf';
$targetPath = $uploadDir . '/' . $fileName;
if (!move_uploaded_file($_FILES['certificate_file']['tmp_name'], $targetPath)) {
    header('Location: ../user/daftar_sertifikat.php?error=Gagal menyimpan file PDF');
    exit;
}
$relativeFile = 'uploads/certificates/' . $fileName;

try {
    $pdo->beginTransaction();

    $email = trim((string) ($user['email'] ?? ''));
    if ($email === '') {
        $email = $user['username'] . '@user.local';
    }

    $stmt = $pdo->prepare('INSERT INTO peserta (user_id, nama, email, pelatihan, tanggal_daftar) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$userId, $namaPeserta, $email, $pelatihan, date('Y-m-d')]);
    $pesertaId = (int) $pdo->lastInsertId();

    $nextNumber = (int) $pdo->query('SELECT COUNT(*) + 43 FROM sertifikat')->fetchColumn();
    $certificateId = 'CERT-' . date('Y') . '-' . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    $hash = aslini_sha256_file($targetPath);

    $stmt = $pdo->prepare('INSERT INTO sertifikat (certificate_id, peserta_id, penyelenggara, tanggal_terbit, sha256_hash, certificate_file, status, signature_verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$certificateId, $pesertaId, $pelatihan, date('Y-m-d'), $hash, $relativeFile, 'pending', 0]);

    $pdo->commit();
    header('Location: ../user/status_sertifikat.php?success=Sertifikat berhasil didaftarkan dan menunggu proses admin');
    exit;
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    if (is_file($targetPath)) {
        unlink($targetPath);
    }
    header('Location: ../user/daftar_sertifikat.php?error=Gagal mendaftarkan sertifikat: ' . urlencode($e->getMessage()));
    exit;
}
