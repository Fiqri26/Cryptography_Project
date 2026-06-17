<?php
$activePage = 'dashboard';
$pageTitle = 'Dashboard';
require_once __DIR__ . '/../includes/auth_check.php';

$totalPeserta = (int) $pdo->query('SELECT COUNT(*) FROM peserta')->fetchColumn();
$sertifikatDiterbitkan = (int) $pdo->query("SELECT COUNT(*) FROM sertifikat WHERE status IN ('ditandatangani', 'terkirim')")->fetchColumn();
$menungguSignature = (int) $pdo->query("SELECT COUNT(*) FROM sertifikat WHERE status = 'pending'")->fetchColumn();
$terkirim = (int) $pdo->query("SELECT COUNT(*) FROM sertifikat WHERE status = 'terkirim'")->fetchColumn();

$stmt = $pdo->query(
    'SELECT s.*, p.nama, p.pelatihan
     FROM sertifikat s
     JOIN peserta p ON p.id = s.peserta_id
     ORDER BY s.updated_at DESC, s.id DESC
     LIMIT 5'
);
$recentCertificates = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi Admin - Dashboard</title>
  <link rel="stylesheet" href="../css/admin.css" />
</head>
<body>
  <div class="admin-layout">
    <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

    <main class="main-area">
      <?php include __DIR__ . '/../includes/admin_topbar.php'; ?>

      <section class="content">
        <div class="stat-grid">
          <article class="stat-card">
            <p class="stat-label">Total Peserta</p>
            <p class="stat-value"><?= $totalPeserta ?></p>
          </article>
          <article class="stat-card">
            <p class="stat-label">Sertifikat Diterbitkan</p>
            <p class="stat-value"><?= $sertifikatDiterbitkan ?></p>
          </article>
          <article class="stat-card">
            <p class="stat-label">Menunggu Signature</p>
            <p class="stat-value"><?= $menungguSignature ?></p>
          </article>
          <article class="stat-card">
            <p class="stat-label">Terkirim</p>
            <p class="stat-value"><?= $terkirim ?></p>
          </article>
        </div>

        <section class="panel">
          <div class="panel-header">
            <h2>Sertifikat Terbaru</h2>
          </div>
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Nama Peserta</th>
                  <th>Pelatihan</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!$recentCertificates): ?>
                  <tr><td colspan="4" class="empty-state">Belum ada data sertifikat.</td></tr>
                <?php endif; ?>
                <?php foreach ($recentCertificates as $row): ?>
                  <tr>
                    <td><?= e($row['nama']) ?></td>
                    <td><?= e($row['pelatihan']) ?></td>
                    <td><?= e(formatTanggalIndo($row['tanggal_terbit'])) ?></td>
                    <td><span class="status <?= e(statusClass($row['status'])) ?>"><?= e(statusText($row['status'])) ?></span></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </section>
      </section>
    </main>
  </div>
</body>
</html>
