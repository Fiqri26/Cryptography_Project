<?php
$activePage = 'profil';
$pageTitle = 'Edit Profil';
require_once __DIR__ . '/../includes/user_auth_check.php';

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
$userPhoto = trim((string) ($currentUser['profile_photo'] ?? ''));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi User - Edit Profil</title>
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

        <section class="panel user-edit-card">
          <form action="../actions/update_user_profile.php" method="POST" enctype="multipart/form-data">
            <div class="user-edit-grid">
              <div class="user-edit-form">
                <div class="user-form-row">
                  <label for="full_name">Nama User :</label>
                  <input class="form-control" id="full_name" name="full_name" type="text" placeholder="Isi Nama User" value="<?= e($currentUser['full_name']) ?>" required />
                </div>
                <div class="user-form-row">
                  <label for="current_password">Password :</label>
                  <input class="form-control" id="current_password" name="current_password" type="password" placeholder="Masukan Password Sekarang" />
                </div>
                <div class="user-form-row">
                  <label for="new_password">Password :</label>
                  <input class="form-control" id="new_password" name="new_password" type="password" placeholder="Ubah Password" />
                </div>
              </div>

              <label class="avatar-upload" for="profile_photo">
                <?php if ($userPhoto !== ''): ?>
                  <img src="../<?= e($userPhoto) ?>" alt="Foto Profil" />
                <?php else: ?>
                  <span>＋</span>
                <?php endif; ?>
                <input id="profile_photo" name="profile_photo" type="file" accept="image/png,image/jpeg,image/webp,image/gif" />
              </label>

              <div class="user-email-row">
                <label for="email">Tautkan Gmail :</label>
                <input class="form-control" id="email" name="email" type="email" placeholder="Tautkan Gmail pengguna" value="<?= e($currentUser['email']) ?>" />
              </div>
            </div>
            <div class="user-form-actions">
              <button class="btn" type="submit">Simpan profil</button>
            </div>
          </form>
        </section>
      </section>
    </main>
  </div>
</body>
</html>
