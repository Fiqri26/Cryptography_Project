<?php
$activePage = 'peserta';
$pageTitle = 'Data Peserta';
require_once __DIR__ . '/../includes/auth_check.php';

$q = trim($_GET['q'] ?? '');
$pelatihanFilter = trim($_GET['pelatihan'] ?? '');
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

$pelatihanList = $pdo->query('SELECT DISTINCT pelatihan FROM peserta ORDER BY pelatihan ASC')->fetchAll(PDO::FETCH_COLUMN);

$sql = 'SELECT * FROM peserta WHERE 1=1';
$params = [];
if ($q !== '') {
    $sql .= ' AND (nama LIKE ? OR email LIKE ?)';
    $params[] = '%' . $q . '%';
    $params[] = '%' . $q . '%';
}
if ($pelatihanFilter !== '') {
    $sql .= ' AND pelatihan = ?';
    $params[] = $pelatihanFilter;
}
$sql .= ' ORDER BY tanggal_daftar DESC, id DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$peserta = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi Admin - Data Peserta</title>
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
          <div class="panel-header">
            <h2>Kelola Data Peserta</h2>
            <a class="btn" href="#formTambah">Tambah Peserta</a>
          </div>
          <form class="toolbar" method="GET" action="peserta.php">
            <input class="form-control" type="text" name="q" placeholder="Cari peserta..." value="<?= e($q) ?>" />
            <select name="pelatihan">
              <option value="">Semua Pelatihan</option>
              <?php foreach ($pelatihanList as $pelatihan): ?>
                <option value="<?= e($pelatihan) ?>" <?= $pelatihanFilter === $pelatihan ? 'selected' : '' ?>><?= e($pelatihan) ?></option>
              <?php endforeach; ?>
            </select>
            <button class="btn btn-light" type="submit">Filter</button>
          </form>
          <div class="table-wrap">
            <table>
              <thead><tr><th>No</th><th>Nama</th><th>Email</th><th>Pelatihan</th><th>Tgl Daftar</th><th>Aksi</th></tr></thead>
              <tbody>
                <?php if (!$peserta): ?>
                  <tr><td colspan="6" class="empty-state">Data peserta tidak ditemukan.</td></tr>
                <?php endif; ?>
                <?php foreach ($peserta as $index => $row): ?>
                  <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= e($row['nama']) ?></td>
                    <td><?= e($row['email']) ?></td>
                    <td><?= e($row['pelatihan']) ?></td>
                    <td><?= e(formatTanggalIndo($row['tanggal_daftar'])) ?></td>
                    <td><button class="btn-text" type="button" title="Edit belum diaktifkan">✎</button></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </section>

        <section class="panel" id="formTambah">
          <div class="panel-header"><h2>Tambah Peserta Baru</h2></div>
          <div class="panel-body">
            <form class="form-grid" action="../actions/add_peserta.php" method="POST">
              <div class="form-group">
                <label>Nama Peserta</label>
                <input class="form-control" type="text" name="nama" placeholder="Masukkan nama peserta" required />
              </div>
              <div class="form-group">
                <label>Email</label>
                <input class="form-control" type="email" name="email" placeholder="peserta@email.com" required />
              </div>
              <div class="form-group">
                <label>Pelatihan</label>
                <input class="form-control" type="text" name="pelatihan" placeholder="Contoh: Web Development" required />
              </div>
              <div class="form-group">
                <label>Tanggal Daftar</label>
                <input class="form-control" type="date" name="tanggal_daftar" value="<?= e(date('Y-m-d')) ?>" required />
              </div>
              <div class="form-group">
                <button class="btn" type="submit">Simpan Peserta</button>
                <p class="form-help">Saat peserta ditambahkan, sistem otomatis membuat data sertifikat berstatus pending.</p>
              </div>
            </form>
          </div>
        </section>
      </section>
    </main>
  </div>
</body>
</html>
