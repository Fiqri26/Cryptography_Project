<?php
$activePage = 'riwayat';
$pageTitle = 'Riwayat Sertifikat';
require_once __DIR__ . '/../includes/auth_check.php';

$stmt = $pdo->query(
    'SELECT s.*, p.nama, p.pelatihan, p.email
     FROM sertifikat s
     JOIN peserta p ON p.id = s.peserta_id
     ORDER BY s.updated_at DESC, s.id DESC'
);
$certificates = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi Admin - Riwayat Sertifikat</title>
  <link rel="stylesheet" href="../css/admin.css" />
</head>
<body>
  <div class="admin-layout">
    <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

    <main class="main-area">
      <?php include __DIR__ . '/../includes/admin_topbar.php'; ?>
      <section class="content">
        <section class="panel">
          <div class="panel-header">
            <h2>Riwayat Sertifikat Ditandatangani</h2>
            <a class="btn-light btn" href="../actions/export_riwayat.php">Export</a>
          </div>
          <div class="panel-body">
            <ul class="history-list">
              <?php if (!$certificates): ?>
                <li class="empty-state">Belum ada riwayat sertifikat.</li>
              <?php endif; ?>
              <?php foreach ($certificates as $row): ?>
                <li class="history-item">
                  <span class="history-dot">◎</span>
                  <div>
                    <p class="history-title"><?= e($row['nama']) ?> — <?= e($row['pelatihan']) ?></p>
                    <p class="history-meta"><?= e($row['certificate_id']) ?> · SHA-256: <?= e(substr($row['sha256_hash'], 0, 14)) ?>... · <?= e(statusText($row['status'])) ?></p>
                  </div>
                  <div class="history-state">
                    <span class="status <?= e(statusClass($row['status'])) ?>"><?= e(statusText($row['status'])) ?></span>
                    <span class="history-time"><?= e($row['signed_at'] ? formatTanggalIndo($row['signed_at']) : formatTanggalIndo($row['updated_at'])) ?></span>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </section>
      </section>
    </main>
  </div>
</body>
</html>
