
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi Admin - Dashboard</title>
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
            <p class="stat-value"></p>
          </article>
          <article class="stat-card">
            <p class="stat-label">Sertifikat Diterbitkan</p>
            <p class="stat-value"></p>
          </article>
          <article class="stat-card">
            <p class="stat-label">Menunggu Signature</p>
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
