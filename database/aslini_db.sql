CREATE DATABASE IF NOT EXISTS aslini_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE aslini_db;

DROP TABLE IF EXISTS sertifikat;
DROP TABLE IF EXISTS peserta;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS admins;

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  username VARCHAR(60) NOT NULL UNIQUE,
  email VARCHAR(120) DEFAULT NULL,
  phone VARCHAR(30) DEFAULT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'Administrator',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  username VARCHAR(60) NOT NULL UNIQUE,
  email VARCHAR(120) DEFAULT NULL,
  phone VARCHAR(30) DEFAULT NULL,
  profile_photo VARCHAR(255) DEFAULT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE peserta (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT DEFAULT NULL,
  nama VARCHAR(120) NOT NULL,
  email VARCHAR(120) NOT NULL,
  pelatihan VARCHAR(150) NOT NULL,
  tanggal_daftar DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_peserta_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE sertifikat (
  id INT AUTO_INCREMENT PRIMARY KEY,
  certificate_id VARCHAR(40) NOT NULL UNIQUE,
  peserta_id INT NOT NULL,
  penyelenggara VARCHAR(150) NOT NULL,
  tanggal_terbit DATE NOT NULL,
  sha256_hash CHAR(64) NOT NULL,
  certificate_file VARCHAR(255) DEFAULT NULL,
  digital_signature TEXT DEFAULT NULL,
  signature_verified TINYINT(1) NOT NULL DEFAULT 0,
  status ENUM('pending', 'ditandatangani', 'terkirim') NOT NULL DEFAULT 'pending',
  signed_at DATETIME DEFAULT NULL,
  sent_at DATETIME DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_sertifikat_peserta FOREIGN KEY (peserta_id) REFERENCES peserta(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Akun admin utama:
-- Username: Putra
-- Password: 123
INSERT INTO admins (full_name, username, email, phone, password_hash, role) VALUES
('Putra Heryan Gagah Perkasa', 'Putra', 'putraheryan15@gmail.com', '+62 812-xxxx-xxxx', '$2y$12$IW6VVtBxVpdFHhOWSmaFdOE1Eg5U6LJAo5tLffpyWzKLDYVMAom9m', 'Administrator');

-- Akun user contoh untuk mencoba halaman user:
-- Username: Jordy
-- Password: 123
INSERT INTO users (id, full_name, username, email, phone, profile_photo, password_hash) VALUES
(1, 'Jordy', 'Jordy', 'CeoPudingCoklat@gmail.com', NULL, NULL, '$2y$12$Wy0ITMGS50m2HnKOu5grDuiTqKaMcV1GOpV2Figcf7ISrrMwZtQri');

INSERT INTO peserta (id, user_id, nama, email, pelatihan, tanggal_daftar) VALUES
(1, 1, 'Muhammad Fiqri Jordy', 'CeoPudingCoklat@gmail.com', 'Web Development 2026', '2026-06-03'),
(2, NULL, 'Budi Santoso', 'budi@email.com', 'Web Development 2024', '2024-10-01'),
(3, NULL, 'Dewi Anggraini', 'dewi@email.com', 'Data Science Dasar', '2024-10-02'),
(4, NULL, 'Rizky Pratama', 'rizky@email.com', 'UI/UX Bootcamp', '2024-10-03'),
(5, 1, 'Muhammad Fiqri Jordy', 'CeoPudingCoklat@gmail.com', 'Data Science Dasar', '2026-06-04');

INSERT INTO sertifikat (certificate_id, peserta_id, penyelenggara, tanggal_terbit, sha256_hash, certificate_file, digital_signature, signature_verified, status, signed_at, sent_at) VALUES
('CERT-2026-0042', 1, 'Pelatihan Web Development 2026', '2026-06-03', '435cbd8ff2c0def2c2156297b566ffbab525a23bc23794c455a85d8c4616b5d4', 'uploads/certificates/certificate_jordy_demo.pdf', 'ZBdymtfyD3YHbe1aFM/vOozvA7MRJG+UgeZ4Yl6dB86+nITdtFWHGmTF+7lb5qxEh0WouPNTm3CdjlWSQIzzaC7uKYP8bPWDBfpH59kLnsObqnmL8tGwzq+26axf1jvbaJ8VERAYofvPKTQGlqhfYbqSLFnU369iI9b3OykBeUnvF9aqzM5pGw1+v797FZZCg0qpIOjo7Cc/BaoNqF7/msHl3nVaUGtA09zueTWT44z0ILXCFt6QzXCGrpqkaDn/+GSeUCSooa6mbFqlCmPfTbcrTqAglfeZiaJhl536bpHJMhyGc7LKjyxy0kVT0BOcmRL8JKKIpxAhb3yybL81hg==', 1, 'terkirim', '2026-06-03 09:15:00', '2026-06-03 09:20:00'),
('CERT-2024-0042', 2, 'Web Development 2024', '2024-10-12', '85debee5d3964063f28bf90fa31f5014c903f3a58ed70927e7ee4d8f9a64a9f9', NULL, 'boTC17RMYhO8NjO075ZSzZ2ecAJYpGHlyljKSWrFfqtmCUTS2vM650aApf0kmWYnopmkeAfT8/EaOFkCLONWW/NEgNfoHHyXdcf4zIhvrkzEqEeeKSJYNQeSHVeY8Oh5oBpTKx8g4zYgXnwdox3TQ73K4FFmGBYtluJR1WcIpAYd8sd3zeL6GVLvn0TRZq25g08CF+Fy9P6jNld0Nr3T/u4GlYokDlH8Hj5O/eDydI9MhCaW5+/xI/q7ZQcTD4l5X56IHHm5esnNu9iTCOFBN8TKJMursAjjahUHc4jco43YdKmUsrpxKn3fnrDzSt0H8D/+FuzPBLqWJbmp5Cxh8w==', 1, 'terkirim', '2024-10-12 09:15:00', '2024-10-12 09:20:00'),
('CERT-2024-0041', 3, 'Data Science Dasar', '2024-10-11', '47331e158ef5273b4c2df4f38cd6c9cbcdfd3af3583b17988cd3f36092337d40', NULL, 'qpdKVFzxgPE7RiDtI/YnpIJ2E8w6f6YFgjFRbFtOVJbVJjkmD903P9LM/8mhPYNDbri1n6c47d9UchEduGuyxM/IJl46lHl/Wlh5WNnPGxPk4+rFZ5XBugooKdqE1gC1lw1Hj3i1d0G6KNH2sNogt+Zn6WkgQWyGoUAju5VUpCbFZuhl49QSDxj+lnwp/66ZDV+8VoQNwvxicqv5tbTCvB5aeC9+pFBiukVt0DKAYzBSuWiWfM6kYqeiwr7R2btHThD0hwWKTBBXSpxMjd+62oA+YMypytCPltlx1V7bZx+b1tENshORPt+0ybIdkDf5mZRxkwPRzgQ60vPyyA4yuA==', 1, 'ditandatangani', '2024-10-11 14:32:00', NULL),
('CERT-2024-0040', 4, 'UI/UX Bootcamp', '2024-10-10', '64b7fbf0c704a9d9d93db731448dc99403c3a3dc800e1c6f407ff802cbc39390', NULL, NULL, 0, 'pending', NULL, NULL),
('CERT-2026-0043', 5, 'Data Science Dasar', '2026-06-04', '7ec53454d3239c554f445d3c02dbb93137d259ef7ed4f9789011abc5c4b43a91', NULL, NULL, 0, 'pending', NULL, NULL);
