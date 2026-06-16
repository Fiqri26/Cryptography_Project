<?php

require_once __DIR__ . '/../config/auth.php';

$nameParts = explode(' ', $admin['fullname']);

$initial =
    strtoupper(
        substr($nameParts[0], 0, 1) .
        substr($nameParts[1], 0, 1)
    );
?>

<header class="topbar">
  <h1>Dashboard</h1>
  <div class="topbar-actions">
    <span>🔔</span>
    <span class="topbar-avatar"><?= $initial ?></span>
  </div>
</header>
