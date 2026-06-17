<?php
$activePage = 'profil';
$pageTitle = 'Profil Admin';
require_once __DIR__ . '/../includes/auth_check.php';

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi Admin - Profil Admin</title>
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
          <div class="profile-head">
            <span class="profile-avatar"><?= e($currentAdminInitials) ?></span>
            <div>
              <h2><?= e($currentAdmin['full_name']) ?></h2>
              <p style="color:#7d8391;"><?= e($currentAdmin['role']) ?> · Kriptografi App</p>
            </div>
          </div>
          <form action="../actions/update_profile.php" method="POST">
            <div class="panel-body">
              <div class="form-grid">
                <div class="form-group"><label>Nama Lengkap</label><input class="form-control" name="full_name" value="<?= e($currentAdmin['full_name']) ?>" required /></div>
                <div class="form-group"><label>Username</label><input class="form-control" name="username" value="<?= e($currentAdmin['username']) ?>" required /></div>
                <div class="form-group"><label>Email</label><input class="form-control" type="email" name="email" value="<?= e($currentAdmin['email']) ?>" /></div>
                <div class="form-group"><label>Nomor Telepon</label><input class="form-control" name="phone" value="<?= e($currentAdmin['phone']) ?>" /></div>
                <div class="form-group"><label>Password Baru</label><input class="form-control" name="password" placeholder="Kosongkan jika tidak diubah" type="password" /></div>
                <div class="form-group"><label>Konfirmasi Password</label><input class="form-control" name="confirm_password" placeholder="Ulangi password baru" type="password" /></div>
              </div>
            </div>
            <div class="panel-footer">
              <button class="btn btn-light" type="reset">Reset</button>
              <button class="btn" type="submit">Simpan</button>
            </div>
          </form>
        </section>
      </section>
    </main>
  </div>
</body>
</html>
