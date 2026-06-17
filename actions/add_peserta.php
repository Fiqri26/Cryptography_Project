<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php?error=Silakan login terlebih dahulu');
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../crypto/sha256.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/peserta.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$pelatihan = trim($_POST['pelatihan'] ?? '');
$tanggalDaftar = trim($_POST['tanggal_daftar'] ?? date('Y-m-d'));

if ($nama === '' || $email === '' || $pelatihan === '' || $tanggalDaftar === '') {
    header('Location: ../admin/peserta.php?error=Semua field peserta wajib diisi#formTambah');
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('INSERT INTO peserta (nama, email, pelatihan, tanggal_daftar) VALUES (?, ?, ?, ?)');
    $stmt->execute([$nama, $email, $pelatihan, $tanggalDaftar]);
    $pesertaId = (int) $pdo->lastInsertId();

    $nextNumber = (int) $pdo->query('SELECT COUNT(*) + 43 FROM sertifikat')->fetchColumn();
    $certificateId = 'CERT-' . date('Y') . '-' . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    $rawData = $certificateId . '|' . $nama . '|' . $email . '|' . $pelatihan . '|' . $tanggalDaftar;
    $hash = aslini_sha256_data($rawData);

    $stmt = $pdo->prepare('INSERT INTO sertifikat (certificate_id, peserta_id, penyelenggara, tanggal_terbit, sha256_hash, status, signature_verified) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$certificateId, $pesertaId, $pelatihan, date('Y-m-d'), $hash, 'pending', 0]);

    $pdo->commit();
    header('Location: ../admin/peserta.php?success=Peserta berhasil ditambahkan');
    exit;
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    header('Location: ../admin/peserta.php?error=Gagal menambahkan peserta: ' . urlencode($e->getMessage()) . '#formTambah');
    exit;
}
