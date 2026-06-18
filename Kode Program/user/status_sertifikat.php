<?php
$activePage = 'status';
$pageTitle = 'Status Sertifikat';
require_once __DIR__ . '/../includes/user_auth_check.php';

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

$stmt = $pdo->prepare(
    "SELECT s.*, p.nama, p.pelatihan
     FROM sertifikat s
     JOIN peserta p ON p.id = s.peserta_id
     WHERE p.user_id = ?
     ORDER BY s.created_at DESC, s.id DESC"
);
$stmt->execute([(int) $currentUser['id']]);
$certificates = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi User - Status Sertifikat</title>
  <link rel="stylesheet" href="../css/admin.css" />
</head>
<body>
  <div class="admin-layout user-layout">
    <?php include __DIR__ . '/../includes/user_sidebar.php'; ?>
    <main class="main-area">
      <?php include __DIR__ . '/../includes/user_topbar.php'; ?>
      <section class="content">
        <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>

        <section class="panel user-status-card">
          <div class="panel-header"><h2>Status Sertifikat yang Telah Terdaftar</h2></div>
          <div class="table-wrap">
            <table>
              <thead><tr><th>Nama Peserta</th><th>Pelatihan</th><th>Status</th><th>Aksi</th></tr></thead>
              <tbody>
                <?php if (!$certificates): ?>
                  <tr><td colspan="4" class="empty-state">Belum ada sertifikat yang didaftarkan.</td></tr>
                <?php endif; ?>
                <?php foreach ($certificates as $row): ?>
                  <?php
                    $accepted = (int) $row['signature_verified'] === 1 && in_array($row['status'], ['ditandatangani', 'terkirim'], true);
                    $hasFile = trim((string) ($row['certificate_file'] ?? '')) !== '';
                  ?>
                  <tr>
                    <td><?= e($row['nama']) ?></td>
                    <td><?= e($row['pelatihan']) ?></td>
                    <td><span class="status <?= $accepted ? 'status-success' : 'status-warning' ?>"><?= $accepted ? 'Diterima' : 'Pending' ?></span></td>
                    <td>
                      <?php if ($accepted && $hasFile): ?>
                        <a class="btn btn-small" href="../actions/download_certificate.php?id=<?= (int) $row['id'] ?>">Download</a>
                      <?php elseif ($accepted): ?>
                        <span class="action-muted">File belum tersedia</span>
                      <?php else: ?>
                        <span class="action-muted">Menunggu admin</span>
                      <?php endif; ?>
                    </td>
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
