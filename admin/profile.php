<?php

require_once __DIR__ . '/../includes/auth_check.php';

$admin = $currentAdmin;

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsliNi Admin - Profil Admin</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-layout">

    <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

    <main class="main-area">

        <?php include __DIR__ . '/../includes/admin_topbar.php'; ?>

        <section class="content">

            <section class="panel">

                <div class="profile-head">
                    <span class="profile-avatar">
                        <?= htmlspecialchars($currentAdminInitials) ?>
                    </span>

                    <div>
                        <h2><?= htmlspecialchars($admin['full_name']) ?></h2>

                        <p style="color:#7d8391;">
                            <?= htmlspecialchars($admin['role']) ?>
                        </p>
                    </div>
                </div>

                <form action="../actions/update_profile.php" method="POST">

                    <div class="panel-body">

                        <div class="form-grid">

                            <div class="form-group">
                                <label>Nama Lengkap</label>

                                <input
                                    class="form-control"
                                    type="text"
                                    name="full_name"
                                    value="<?= htmlspecialchars($admin['full_name']) ?>"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label>Username</label>

                                <input
                                    class="form-control"
                                    type="text"
                                    name="username"
                                    value="<?= htmlspecialchars($admin['username']) ?>"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label>Email</label>

                                <input
                                    class="form-control"
                                    type="email"
                                    name="email"
                                    value="<?= htmlspecialchars($admin['email']) ?>"
                                >
                            </div>

                            <div class="form-group">
                                <label>Nomor Telepon</label>

                                <input
                                    class="form-control"
                                    type="text"
                                    name="phone"
                                    value="<?= htmlspecialchars($admin['phone']) ?>"
                                >
                            </div>

                            <div class="form-group">
                                <label>Password Baru</label>

                                <input
                                    class="form-control"
                                    type="password"
                                    name="password"
                                    placeholder="Kosongkan jika tidak diubah"
                                >
                            </div>

                            <div class="form-group">
                                <label>Konfirmasi Password</label>

                                <input
                                    class="form-control"
                                    type="password"
                                    name="confirm_password"
                                    placeholder="Ulangi password baru"
                                >
                            </div>

                        </div>

                    </div>

                    <div class="panel-footer">
                        <button class="btn" type="submit">
                            Simpan
                        </button>
                    </div>

                </form>

            </section>

        </section>

    </main>

</div>

</body>
</html>
