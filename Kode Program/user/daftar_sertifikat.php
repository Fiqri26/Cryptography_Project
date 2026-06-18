<?php
$activePage = 'daftar';
$pageTitle = 'Daftar Sertifikat';
require_once __DIR__ . '/../includes/user_auth_check.php';

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi User - Daftar Sertifikat</title>
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

        <div class="user-page-title">
          <h2>Daftar kan Sertifikat Anda Disini!</h2>
          <p>Wajib untuk mengisi nama peserta pada sertifikat dengan pelatihan yang di ikuti</p>
        </div>

        <section class="panel certificate-register-card">
          <form action="../actions/register_certificate.php" method="POST" enctype="multipart/form-data">
            <div class="certificate-form-row">
              <label for="nama_peserta">Nama Peserta :</label>
              <input class="form-control" id="nama_peserta" name="nama_peserta" type="text" required />
            </div>
            <div class="certificate-form-row">
              <label for="pelatihan">Pelatihan :</label>
              <input class="form-control" id="pelatihan" name="pelatihan" type="text" required />
            </div>
            <label class="upload-dropzone user-upload" for="certificate_file">
              <input id="certificate_file" name="certificate_file" type="file" accept="application/pdf" required />
              <span>Seret file PDF ke sini atau klik untuk memilih</span>
              <small>Format: PDF, maks 10mb</small>
            </label>
            <div class="user-form-actions">
              <button class="btn" type="submit">Daftar Sekarang</button>
            </div>
          </form>
        </section>
      </section>
    </main>
  </div>
</body>
</html>
