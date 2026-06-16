<?php

/** @var PDO $pdo */
/** @var array $admin */
/** @var string $currentAdminInitials */

$admin = $admin ?? [
    'full_name' => 'Administrator',
    'role'      => 'Admin'
];

$currentAdminInitials = $currentAdminInitials ?? 'AD';

$sidebarPesertaCount = 0;

try {
    $sidebarPesertaCount = (int) $pdo
        ->query('SELECT COUNT(*) FROM peserta')
        ->fetchColumn();
} catch (Throwable $e) {
    $sidebarPesertaCount = 0;
}
?>

<aside class="sidebar">
    <a href="dashboard.php" class="sidebar-brand">
        ✓ AsliNi
    </a>

    <div class="sidebar-profile">
        <span class="admin-avatar">
            <?= htmlspecialchars($currentAdminInitials) ?>
        </span>

        <div>
            <p class="admin-name">
                <?= htmlspecialchars($admin['full_name']) ?>
            </p>

            <p class="admin-role">
                <?= htmlspecialchars($admin['role']) ?>
            </p>
        </div>
    </div>

    <nav>
        <div class="side-section">
            <p class="side-label">Menu Utama</p>

            <ul class="side-menu">
                <li>
                    <a
                        class="<?= ($activePage ?? '') === 'dashboard' ? 'active' : '' ?>"
                        href="dashboard.php"
                    >
                        <i class="fa-solid fa-home"></i>
                        Dashboard
                    </a>
                </li>
            </ul>
        </div>

        <div class="side-section">
            <p class="side-label">Manajemen</p>

            <ul class="side-menu">
                <li>
                    <a
                        class="<?= ($activePage ?? '') === 'peserta' ? 'active' : '' ?>"
                        href="peserta.php"
                    >
                        <i class="fa-solid fa-users"></i>
                        Data Peserta
                    </a>
                </li>

                <li>
                    <a
                        class="<?= ($activePage ?? '') === 'sertifikat' ? 'active' : '' ?>"
                        href="sertifikat.php"
                    >
                        <i class="fa-solid fa-award"></i>
                        Sertifikat
                    </a>
                </li>

                <li>
                    <a
                        class="<?= ($activePage ?? '') === 'signature' ? 'active' : '' ?>"
                        href="signature.php"
                    >
                        <i class="fa-solid fa-signature"></i>
                        Digital Signature
                    </a>
                </li>
            </ul>
        </div>

        <div class="side-section">
            <p class="side-label">Akun</p>

            <ul class="side-menu">
                <li>
                    <a
                        class="<?= ($activePage ?? '') === 'profil' ? 'active' : '' ?>"
                        href="profile.php"
                    >
                        <i class="fa-solid fa-user-gear"></i>
                        Profil
                    </a>
                </li>

                <li>
                    <a href="logout.php">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>
