<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

$id_admin = $_SESSION['admin_id'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM admin WHERE id_admin = '$id_admin'"
);

$admin = mysqli_fetch_assoc($query);

if (!$admin) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}
