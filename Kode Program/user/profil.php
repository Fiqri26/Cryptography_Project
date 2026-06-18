<?php
$activePage = 'profil';
$pageTitle = 'Profil';
require_once __DIR__ . '/../includes/user_auth_check.php';

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
$displayName = $currentUser['full_name'] ?: $currentUser['username'];
$email = $currentUser['email'] ?: '-';
$userPhoto = trim((string) ($currentUser['profile_photo'] ?? ''));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsliNi User - Profil</title>
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

        <section class="panel user-profile-card">
          <div class="user-profile-body">
            <?php if ($userPhoto !== ''): ?>
              <img class="user-profile-photo" src="../<?= e($userPhoto) ?>" alt="Foto Profil" />
            <?php else: ?>
              <div class="user-profile-photo user-profile-placeholder"><?= e($currentUserInitials) ?></div>
            <?php endif; ?>

            <div class="user-profile-info">
              <p><strong>Nama User :</strong> <span><?= e($displayName) ?></span></p>
              <p><strong>Gmail :</strong> <span><?= e($email) ?></span></p>
            </div>

            <a class="btn user-edit-button" href="edit_profil.php">Edit profil</a>
          </div>
        </section>
      </section>
    </main>
  </div>
</body>
</html>
