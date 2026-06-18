<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/crypto/sha256.php';
require_once __DIR__ . '/crypto/generate_key.php';

$resultStatus = null;
$resultMessage = '';
$certificate = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $certificateId = trim($_POST['certificate_id'] ?? '');
    $fileHash = null;

    if (isset($_FILES['certificate_file']) && $_FILES['certificate_file']['error'] === UPLOAD_ERR_OK) {
        $allowedMime = ['application/pdf', 'application/x-pdf'];
        $maxSize = 10 * 1024 * 1024;
        $fileType = mime_content_type($_FILES['certificate_file']['tmp_name']);

        if ($_FILES['certificate_file']['size'] > $maxSize) {
            $resultStatus = 'invalid';
            $resultMessage = 'Ukuran file melebihi batas 10 MB.';
        } elseif (!in_array($fileType, $allowedMime, true)) {
            $resultStatus = 'invalid';
            $resultMessage = 'File harus berformat PDF.';
        } else {
            $fileHash = aslini_sha256_file($_FILES['certificate_file']['tmp_name']);
        }
    }

    if ($resultStatus === null) {
        if ($certificateId === '' && $fileHash === null) {
            $resultStatus = 'invalid';
            $resultMessage = 'Masukkan ID sertifikat atau unggah file PDF terlebih dahulu.';
        } else {
            $where = '';
            $params = [];

            if ($certificateId !== '' && $fileHash !== null) {
                $where = 's.certificate_id = :certificate_id AND s.sha256_hash = :file_hash';
                $params = [
                    'certificate_id' => $certificateId,
                    'file_hash' => $fileHash,
                ];
            } elseif ($certificateId !== '') {
                $where = 's.certificate_id = :certificate_id';
                $params = ['certificate_id' => $certificateId];
            } else {
                $where = 's.sha256_hash = :file_hash';
                $params = ['file_hash' => $fileHash];
            }

            $stmt = $pdo->prepare(
                "SELECT s.*, p.nama, p.email, p.pelatihan
                 FROM sertifikat s
                 JOIN peserta p ON p.id = s.peserta_id
                 WHERE {$where}
                 LIMIT 1"
            );
            $stmt->execute($params);
            $certificate = $stmt->fetch();

            $signatureValid = $certificate
                && (int) $certificate['signature_verified'] === 1
                && in_array($certificate['status'], ['ditandatangani', 'terkirim'], true)
                && aslini_verify_hash_signature($certificate['sha256_hash'], $certificate['digital_signature'] ?? null);

            if ($signatureValid) {
                $resultStatus = 'valid';
            } else {
                $resultStatus = 'invalid';
                $resultMessage = 'Digital signature RSA tidak cocok atau data sertifikat tidak ditemukan.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi - Verifikasi Sertifikat</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <header class="site-header">
    <nav class="navbar">
      <a href="index.php" class="logo"><span class="logo-mark">✓</span> AsliNi</a>
      <ul class="nav-links">
        <li><a href="index.php">Beranda</a></li>
        <li><a class="active" href="verifikasi.php">Verifikasi</a></li>
        <li><a href="developer.php">Developer</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <main class="page-main">
    <div class="container">
      <h1 class="page-title">Petunjuk Verifikasi Sertifikat</h1>
      <p class="page-subtitle">Ikuti langkah berikut untuk memverifikasi keaslian sertifikat digital Anda.</p>

      <section class="steps-grid">
        <article class="step-card">
          <span class="step-number">1</span>
          <h3>Siapkan File Sertifikat</h3>
          <p>Pastikan Anda memiliki file PDF sertifikat atau nomor ID sertifikat yang diterbitkan.</p>
        </article>
        <article class="step-card">
          <span class="step-number">2</span>
          <h3>Upload atau Masukkan ID</h3>
          <p>Upload file PDF sertifikat atau masukkan nomor ID sertifikat Anda.</p>
        </article>
        <article class="step-card">
          <span class="step-number">3</span>
          <h3>Lihat Hasil Verifikasi</h3>
          <p>Sistem akan memvalidasi digital signature untuk memastikan keaslian sertifikat.</p>
        </article>
      </section>

      <div class="divider"></div>

      <h2 class="page-title">Verifikasi Sertifikat</h2>
      <p class="page-subtitle">Masukkan ID sertifikat atau unggah file PDF untuk memulai verifikasi. Contoh ID demo: <strong>CERT-2026-0042</strong>.</p>

      <section class="verify-card">
        <form action="verifikasi.php" method="POST" enctype="multipart/form-data">
          <div class="certificate-id-box">
            <label for="certificate_id">ID Sertifikat</label>
            <input class="form-control" type="text" id="certificate_id" name="certificate_id" placeholder="Contoh: CERT-2026-0042" value="<?= e($_POST['certificate_id'] ?? '') ?>" />
          </div>

          <label class="upload-zone" for="certificateFile">
            <input type="file" id="certificateFile" name="certificate_file" accept="application/pdf" />
            <span class="upload-text" id="uploadText">Seret file PDF ke sini atau <strong>klik untuk memilih</strong><br />Format: PDF, maks 10mb</span>
          </label>

          <div class="verify-actions">
            <button class="btn" type="submit">Verifikasi Sertifikat</button>
          </div>
        </form>

        <?php if ($resultStatus === 'valid' && $certificate): ?>
          <div class="result-box result-success static-result">
            <h3>Sertifikat Valid &amp; Asli</h3>
            <p>ID: <?= e($certificate['certificate_id']) ?> · Pemegang: <?= e($certificate['nama']) ?> · Diterbitkan <?= e(formatTanggalIndo($certificate['tanggal_terbit'])) ?> · Penyelenggara: <?= e($certificate['penyelenggara']) ?></p>
            <p>Digital Signature: Terverifikasi</p>
          </div>
        <?php elseif ($resultStatus === 'invalid'): ?>
          <div class="result-box result-danger static-result">
            <h3>Sertifikat Tidak Valid</h3>
            <p><?= e($resultMessage) ?></p>
          </div>
        <?php endif; ?>
      </section>
    </div>
  </main>

  <script src="js/script.js"></script>
</body>
</html>
