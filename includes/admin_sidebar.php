<aside class="sidebar">
  <a href="../index.php" class="sidebar-brand">✓ AsliNi</a>
  <div class="sidebar-profile">
    <span class="admin-avatar"></span>
    <div>
      <p class="admin-name"></p>
      <p class="admin-role"></p>
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
        <li><a class="<?= ($activePage ?? '') === 'peserta' ? 'active' : '' ?>" href="peserta.php">👥 Data Peserta <span class="side-count"></span></a></li>
        <li><a class="<?= ($activePage ?? '') === 'signature' ? 'active' : '' ?>" href="signature.php">✒ Signature</a></li>

      </ul>
    </div>

    <div class="side-section">
      <p class="side-label">Akun</p>
      <ul class="side-menu">
        <li><a class="<?= ($activePage ?? '') === 'profil' ? 'active' : '' ?>" href="profile.php">◉ Profil Admin</a></li>
        <li><a href="logout.php">↩ Logout</a></li>
      </ul>
    </div>
  </nav>
</aside>
