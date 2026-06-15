<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi - Sertifikat</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
  <header class="site-header">
    <nav class="navbar">
      <a href="index.php" class="logo"><span class="logo-mark">✓</span> AsliNi</a>
      <ul class="nav-links">
        <li><a href="index.php">Beranda</a></li>
        <li><a class="active" href="certif_print.php">Unduh Sertifikat</a></li>
        <li><a href="certif_verify.php">Verifikasi</a></li>
        <li><a href="pengembang.php">Pengembang</a></li>
      </ul>
    </nav>
  </header>
  <main class="page-main">
    <div class="container">

        <h1 class="page-title">Unduh Sertifikat</h1>
        <p class="page-subtitle">
            Masukkan nama peserta dan nama pelatihan untuk mencari sertifikat.
        </p>

        <div class="search-card">

            <div id="errorAlert" class="cert-alert cert-alert-error">
                <span>Sertifikat yang Anda cari tidak ditemukan.</span>
                <button type="button" class="close-alert">&times;</button>
            </div>

            <div class="form-group">
                <label for="participantName">Nama Peserta</label>
                <input
                    type="text"
                    id="participantName"
                    class="form-control"
                    placeholder="Masukkan nama peserta">
            </div>

            <div class="form-group">
                <label for="trainingName">Nama Pelatihan</label>
                <input
                    type="text"
                    id="trainingName"
                    class="form-control"
                    placeholder="Masukkan nama pelatihan">
            </div>

            <button id="searchBtn" class="btn">
                Cari
            </button>

            <div id="pdfContainer" class="pdf-container">

                <div class="pdf-header">
                    <h3>Sertifikat Ditemukan</h3>
                </div>

                <iframe
                    src="assets/certificates/Sertif komp.pdf"
                    class="pdf-viewer">
                </iframe>

            </div>

        </div>

    </div>
</main>

<link rel="stylesheet" href="assets/css/certif_print.css">
<script src="assets/js/script.js"></script>
  </main>
</body>
</html>
