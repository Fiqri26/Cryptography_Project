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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/admin.css" />
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
            <p class="stat-label">Total Sertifikat</p>
            <p class="stat-value"></p>
          </article>
          <article class="stat-card">
            <p class="stat-label">Menunggu Signature</p>
            <p class="stat-value"></p>
          </article>
          <article class="stat-card">
            <p class="stat-label">Total Validasi Sertifikat</p>
            <p class="stat-value"></p>
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
                  <th>Tanggal Daftar</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>

              </tbody>
            </table>
          </div>
        </section>
      </section>
    </main>
  </div>
</body>
</html>
