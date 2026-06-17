<?php
$sidebarPesertaCount = 0;
try {
    $sidebarPesertaCount = (int) $pdo->query('SELECT COUNT(*) FROM peserta')->fetchColumn();
} catch (Throwable $e) {
    $sidebarPesertaCount = 0;
}
?>
<aside class="sidebar">
  <a href="../index.php" class="sidebar-brand">✓ AsliNi</a>
  <div class="sidebar-profile">
    <span class="admin-avatar"><?= e($currentAdminInitials) ?></span>
    <div>
      <p class="admin-name"><?= e($currentAdmin['full_name']) ?></p>
      <p class="admin-role"><?= e($currentAdmin['role']) ?></p>
    </div>
  </div>

  <nav>
    <div class="side-section">
      <p class="side-label">Menu Utama</p>
      <ul class="side-menu">
        <li><a class="<?= ($activePage ?? '') === 'dashboard' ? 'active' : '' ?>" href="dashboard.php">▦ Dashboard</a></li>
      </ul>
    </div>
    <div class="side-section">
      <p class="side-label">Manajemen</p>
      <ul class="side-menu">
        <li><a class="<?= ($activePage ?? '') === 'peserta' ? 'active' : '' ?>" href="peserta.php">👥 Data Peserta <span class="side-count"><?= $sidebarPesertaCount ?></span></a></li>
        <li><a class="<?= ($activePage ?? '') === 'signature' ? 'active' : '' ?>" href="signature.php">✒ Tanda Tangan</a></li>
      </ul>
    </div>
    <div class="side-section">
      <p class="side-label">Riwayat &amp; Laporan</p>
      <ul class="side-menu">
        <li><a class="<?= ($activePage ?? '') === 'riwayat' ? 'active' : '' ?>" href="riwayat.php">↺ Riwayat Sertifikat</a></li>
      </ul>
    </div>
    <div class="side-section">
      <p class="side-label">Akun</p>
      <ul class="side-menu">
        <li><a class="<?= ($activePage ?? '') === 'profil' ? 'active' : '' ?>" href="profil.php">◉ Profil Admin</a></li>
        <li><a href="../logout.php">↩ Logout</a></li>
      </ul>
    </div>
  </nav>
</aside>
