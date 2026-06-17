<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php?error=Silakan login terlebih dahulu');
    exit;
}

require_once __DIR__ . '/../config/database.php';

$stmt = $pdo->query(
    'SELECT s.certificate_id, p.nama, p.email, p.pelatihan, s.tanggal_terbit, s.sha256_hash, s.status, s.signed_at
     FROM sertifikat s
     JOIN peserta p ON p.id = s.peserta_id
     ORDER BY s.updated_at DESC, s.id DESC'
);
$rows = $stmt->fetchAll();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="riwayat-sertifikat.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID Sertifikat', 'Nama', 'Email', 'Pelatihan', 'Tanggal Terbit', 'SHA-256', 'Status', 'Tanggal Signature']);
foreach ($rows as $row) {
    fputcsv($output, [
        $row['certificate_id'],
        $row['nama'],
        $row['email'],
        $row['pelatihan'],
        $row['tanggal_terbit'],
        $row['sha256_hash'],
        $row['status'],
        $row['signed_at'],
    ]);
}
fclose($output);
exit;
