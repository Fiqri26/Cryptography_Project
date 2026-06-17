<?php
$activePage = 'signature';
$pageTitle = 'Digital Signature RSA';
require_once __DIR__ . '/../includes/auth_check.php';

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

$stmt = $pdo->query(
    "SELECT s.*, p.nama, p.pelatihan
     FROM sertifikat s
     JOIN peserta p ON p.id = s.peserta_id
     WHERE s.status = 'pending'
     ORDER BY s.created_at ASC"
);
$pendingCertificates = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi Admin - Digital Signature RSA</title>
  <link rel="stylesheet" href="../css/admin.css" />
</head>
<body>
  <div class="admin-layout">
    <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

    <main class="main-area">
      <?php include __DIR__ . '/../includes/admin_topbar.php'; ?>
      <section class="content">
        <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>

        <section class="panel">
          <div class="panel-header"><h2>Digital Signature RSA</h2></div>
          <div class="panel-body">
            <p style="color:#7d8391;line-height:1.7;">Alur proses pembubuhan digital signature pada sertifikat PDF.</p>
            <div class="flow-grid">
              <article class="flow-card"><span class="flow-icon">≋</span><h3>1. Hash PDF</h3><p>Hitung nilai hash SHA-256 dari file sertifikat PDF.</p></article>
              <article class="flow-card"><span class="flow-icon">钥</span><h3>2. Private Key RSA</h3><p>Enkripsi hash menggunakan private key RSA milik penyelenggara.</p></article>
              <article class="flow-card"><span class="flow-icon">✒</span><h3>3. Simpan Signature</h3><p>Signature disimpan di database bersama sertifikat PDF.</p></article>
              <article class="flow-card"><span class="flow-icon">✉</span><h3>4. Kirim ke Peserta</h3><p>Sertifikat dikirim ke email peserta yang terdaftar.</p></article>
            </div>
          </div>
          <div class="panel-body">
            <h2 style="font-size:18px;margin-bottom:18px;">Pilih Sertifikat untuk Ditandatangani</h2>
            <div class="table-wrap">
              <table>
                <thead><tr><th>Nama Peserta</th><th>Sertifikat</th><th>Hash SHA-256</th><th>Aksi</th></tr></thead>
                <tbody>
                  <?php if (!$pendingCertificates): ?>
                    <tr><td colspan="4" class="empty-state">Tidak ada sertifikat yang menunggu tanda tangan.</td></tr>
                  <?php endif; ?>
                  <?php foreach ($pendingCertificates as $row): ?>
                    <tr>
                      <td><?= e($row['nama']) ?></td>
                      <td><?= e($row['pelatihan']) ?></td>
                      <td><?= e(substr($row['sha256_hash'], 0, 10)) ?>...</td>
                      <td>
                        <form class="inline-form" action="../actions/sign_certificate.php" method="POST">
                          <input type="hidden" name="id" value="<?= (int) $row['id'] ?>" />
                          <button class="btn-text" type="submit">Tanda Tangani</button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </section>
    </main>
  </div>
</body>
</html>
