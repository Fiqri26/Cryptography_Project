<?php

session_start();

require_once __DIR__ . '/../config/database.php';

$id_admin = $_SESSION['admin_id'];

$fullname = trim($_POST['fullname']);
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$role = trim($_POST['role']);
$nomor_telepon = trim($_POST['nomor_telepon']);

$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if (!empty($password)) {

    if ($password !== $confirm_password) {

        die("Konfirmasi password tidak cocok.");

    }

    $hash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $query = mysqli_prepare(
        $conn,
        "UPDATE admin
         SET fullname=?,
             username=?,
             email=?,
             role=?,
             nomor_telepon=?,
             password=?
         WHERE id_admin=?"
    );

    mysqli_stmt_bind_param(
        $query,
        "ssssssi",
        $fullname,
        $username,
        $email,
        $role,
        $nomor_telepon,
        $hash,
        $id_admin
    );

} else {

    $query = mysqli_prepare(
        $conn,
        "UPDATE admin
         SET fullname=?,
             username=?,
             email=?,
             role=?,
             no_telepon=?
         WHERE id_admin=?"
    );

    mysqli_stmt_bind_param(
        $query,
        "sssssi",
        $fullname,
        $username,
        $email,
        $role,
        $no_telepon,
        $id_admin
    );
}

mysqli_stmt_execute($query);

header("Location: ../admin/profile.php");
exit;
