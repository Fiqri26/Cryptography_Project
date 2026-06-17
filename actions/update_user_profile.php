<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php?error=Silakan login sebagai user terlebih dahulu');
    exit;
}

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../user/edit_profil.php');
    exit;
}

$userId = (int) $_SESSION['user_id'];
$fullName = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';

if ($fullName === '') {
    header('Location: ../user/edit_profil.php?error=Nama user wajib diisi');
    exit;
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../user/edit_profil.php?error=Format Gmail tidak valid');
    exit;
}

$stmt = $pdo->prepare('SELECT id, password_hash, profile_photo FROM users WHERE id = ? LIMIT 1');
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header('Location: ../login.php?error=Sesi user tidak valid, silakan login ulang');
    exit;
}

$passwordHash = null;
if ($newPassword !== '') {
    if ($currentPassword === '' || !password_verify($currentPassword, $user['password_hash'])) {
        header('Location: ../user/edit_profil.php?error=Password sekarang salah');
        exit;
    }
    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
}

$profilePhoto = $user['profile_photo'];
if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['profile_photo']['error'] !== UPLOAD_ERR_OK) {
        header('Location: ../user/edit_profil.php?error=Gagal mengupload foto profil');
        exit;
    }

    if ($_FILES['profile_photo']['size'] > 2 * 1024 * 1024) {
        header('Location: ../user/edit_profil.php?error=Ukuran foto maksimal 2MB');
        exit;
    }

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];
    $mime = mime_content_type($_FILES['profile_photo']['tmp_name']);
    if (!isset($allowed[$mime])) {
        header('Location: ../user/edit_profil.php?error=Format foto harus JPG, PNG, WEBP, atau GIF');
        exit;
    }

    $uploadDir = __DIR__ . '/../uploads/users';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

    $fileName = 'user_' . $userId . '_' . time() . '.' . $allowed[$mime];
    $targetPath = $uploadDir . '/' . $fileName;
    if (!move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetPath)) {
        header('Location: ../user/edit_profil.php?error=Gagal menyimpan foto profil');
        exit;
    }
    $profilePhoto = 'uploads/users/' . $fileName;
}

if ($passwordHash !== null) {
    $stmt = $pdo->prepare('UPDATE users SET full_name = ?, email = ?, profile_photo = ?, password_hash = ? WHERE id = ?');
    $stmt->execute([$fullName, $email, $profilePhoto, $passwordHash, $userId]);
} else {
    $stmt = $pdo->prepare('UPDATE users SET full_name = ?, email = ?, profile_photo = ? WHERE id = ?');
    $stmt->execute([$fullName, $email, $profilePhoto, $userId]);
}

header('Location: ../user/profil.php?success=Profil berhasil diperbarui');
exit;
