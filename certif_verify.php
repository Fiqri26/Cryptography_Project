<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi - Verifikasi</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

  <header class="site-header">
    <nav class="navbar">
      <a href="index.html" class="logo">
        <span class="logo-mark">✓</span> AsliNi
      </a>

      <ul class="nav-links">
        <li><a href="index.html">Beranda</a></li>
        <li><a href="certif_print.php">Unduh Sertifikat</a></li>
        <li><a class="active" href="certif_verify.php">Verifikasi</a></li>
        <li><a href="pengembang.php">Pengembang</a></li>
      </ul>
    </nav>
  </header>

  <main class="page-main">
    <div class="container">

      <h1 class="page-title">Petunjuk Verifikasi Sertifikat</h1>

      <p class="page-subtitle">
        Ikuti langkah berikut untuk memverifikasi keaslian sertifikat digital Anda.
      </p>

      <section class="steps-grid">

        <article class="step-card">
          <span class="step-number">1</span>
          <h3>Siapkan File Sertifikat</h3>
          <p>
            Pastikan Anda memiliki file sertifikat dalam format PDF.
          </p>
        </article>

        <article class="step-card">
          <span class="step-number">2</span>
          <h3>Unggah File Sertifikat</h3>
          <p>
            Silakan pilih dan unggah file sertifikat Anda.
          </p>
        </article>

        <article class="step-card">
          <span class="step-number">3</span>
          <h3>Lihat Hasil Verifikasi</h3>
          <p>
            Sistem akan memvalidasi digital signature untuk memastikan
            keaslian sertifikat.
          </p>
        </article>

      </section>

      <div class="divider"></div>

      <section class="verify-card">

        <form enctype="multipart/form-data">

          <label class="upload-zone" for="certificateFile">

            <input
              type="file"
              id="certificateFile"
              name="certificate_file"
              accept="application/pdf"
            />

            <span class="upload-text" id="uploadText">
              Seret file PDF ke sini atau
              <strong>klik untuk memilih</strong>
            </span>

          </label>

          <div class="verify-actions">
            <button class="btn" type="submit">
              Verifikasi Sertifikat
            </button>
          </div>

        </form>

      </section>

    </div>
  </main>

  <script src="js/script.js"></script>

</body>
</html>
