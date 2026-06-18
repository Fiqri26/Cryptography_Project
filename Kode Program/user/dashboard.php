<?php
$activePage = 'dashboard';
$pageTitle = 'Dashboard';
require_once __DIR__ . '/../includes/user_auth_check.php';

$stmt = $pdo->prepare(
    "SELECT
      COUNT(*) AS total,
      SUM(CASE WHEN s.status IN ('ditandatangani', 'terkirim') THEN 1 ELSE 0 END) AS diterima,
      SUM(CASE WHEN s.status = 'pending' THEN 1 ELSE 0 END) AS pending
     FROM sertifikat s
     JOIN peserta p ON p.id = s.peserta_id
     WHERE p.user_id = ?"
);
$stmt->execute([(int) $currentUser['id']]);
$stats = $stmt->fetch() ?: ['total' => 0, 'diterima' => 0, 'pending' => 0];

$stmt = $pdo->prepare(
    "SELECT s.*, p.nama, p.pelatihan
     FROM sertifikat s
     JOIN peserta p ON p.id = s.peserta_id
     WHERE p.user_id = ?
     ORDER BY s.updated_at DESC, s.id DESC
     LIMIT 5"
);
$stmt->execute([(int) $currentUser['id']]);
$certificates = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi User - Dashboard</title>
  <link rel="stylesheet" href="../css/admin.css" />
</head>
<body>
  <div class="admin-layout user-layout">
    <?php include __DIR__ . '/../includes/user_sidebar.php'; ?>
    <main class="main-area">
      <?php include __DIR__ . '/../includes/user_topbar.php'; ?>
      <section class="content">
        <div class="stat-grid user-stat-grid">
          <article class="stat-card"><p class="stat-label">Total Sertifikat</p><p class="stat-value"><?= (int) $stats['total'] ?></p></article>
          <article class="stat-card"><p class="stat-label">Diterima</p><p class="stat-value"><?= (int) $stats['diterima'] ?></p></article>
          <article class="stat-card"><p class="stat-label">Pending</p><p class="stat-value"><?= (int) $stats['pending'] ?></p></article>
        </div>

        <section class="panel">
          <div class="panel-header">
            <h2>Status Sertifikat Terbaru</h2>
            <a class="btn" href="daftar_sertifikat.php">Daftar Sertifikat</a>
          </div>
          <div class="table-wrap">
            <table>
              <thead><tr><th>Nama Peserta</th><th>Pelatihan</th><th>Status</th></tr></thead>
              <tbody>
                <?php if (!$certificates): ?>
                  <tr><td colspan="3" class="empty-state">Belum ada sertifikat yang terdaftar.</td></tr>
                <?php endif; ?>
                <?php foreach ($certificates as $row): ?>
                  <?php $accepted = in_array($row['status'], ['ditandatangani', 'terkirim'], true); ?>
                  <tr>
                    <td><?= e($row['nama']) ?></td>
                    <td><?= e($row['pelatihan']) ?></td>
                    <td><span class="status <?= $accepted ? 'status-success' : 'status-warning' ?>"><?= $accepted ? 'Diterima' : 'Pending' ?></span></td>
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
