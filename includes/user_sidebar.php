<?php
$displayName = $currentUser['full_name'] ?: $currentUser['username'];
$userPhoto = trim((string) ($currentUser['profile_photo'] ?? ''));
?>
<aside class="sidebar user-sidebar">
  <a href="../index.php" class="sidebar-brand">✓ AsliNi</a>
  <div class="sidebar-profile">
    <?php if ($userPhoto !== ''): ?>
      <img class="sidebar-photo" src="../<?= e($userPhoto) ?>" alt="Foto Profil" />
    <?php else: ?>
      <span class="admin-avatar"><?= e($currentUserInitials) ?></span>
    <?php endif; ?>
    <div>
      <p class="admin-name"><?= e($displayName) ?></p>
      <p class="admin-role">User</p>
    </div>
  </div>

  <nav>
    <div class="side-section">
      <ul class="side-menu">
        <li><a class="<?= ($activePage ?? '') === 'dashboard' ? 'active' : '' ?>" href="dashboard.php">▦ Dashboard</a></li>
        <li><a class="<?= ($activePage ?? '') === 'profil' ? 'active' : '' ?>" href="profil.php">♙ Profil</a></li>
        <li><a class="<?= ($activePage ?? '') === 'daftar' ? 'active' : '' ?>" href="daftar_sertifikat.php">╲ Daftar Sertifikat</a></li>
        <li><a class="<?= ($activePage ?? '') === 'status' ? 'active' : '' ?>" href="status_sertifikat.php">◌ Status Sertifikat</a></li>
        <li><a href="../logout.php">↩ Logout</a></li>
      </ul>
    </div>
  </nav>
</aside>
