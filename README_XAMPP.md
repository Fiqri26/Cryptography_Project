# AsliNi - XAMPP Version

Project ini sudah menggunakan PHP + MySQL/XAMPP.

## Akun bawaan

Admin:
- Username: `Putra`
- Password: `123`

User contoh:
- Username: `Jordy`
- Password: `123`

Akun baru dari halaman Sign-Up akan masuk ke tabel `users`, bukan ke tabel `admins`.

## Cara menjalankan

1. Copy folder `aslini-xampp` ke:

   ```text
   C:\xampp\htdocs\
   ```

2. Jalankan `Apache` dan `MySQL` dari XAMPP Control Panel.

3. Buka phpMyAdmin:

   ```text
   http://localhost/phpmyadmin
   ```

4. Buat database bernama:

   ```text
   aslini_db
   ```

5. Import file:

   ```text
   database/aslini_db.sql
   ```

6. Buka website:

   ```text
   http://localhost/aslini-xampp/
   ```

7. Login admin:

   ```text
   http://localhost/aslini-xampp/login.php
   ```

8. Login user atau daftar user baru melalui:

   ```text
   http://localhost/aslini-xampp/signup.php
   ```

## Halaman user

Setelah login sebagai user, sistem akan masuk ke:

```text
user/profil.php
```

Halaman user yang tersedia:

- `user/dashboard.php`
- `user/profil.php`
- `user/edit_profil.php`
- `user/daftar_sertifikat.php`
- `user/status_sertifikat.php`

## Perubahan database utama

Tabel baru:

```sql
users
```

Kolom baru:

```sql
peserta.user_id
sertifikat.certificate_file
```

Backend kriptografi:

```text
crypto/sha256.php
crypto/generate_key.php
crypto/private_key.pem
crypto/public_key.pem
```

Sertifikat yang diunggah user dihitung hash SHA-256 dari file PDF, lalu admin menandatangani hash tersebut menggunakan RSA. Verifikasi publik mencocokkan ID/file, status sertifikat, dan digital signature RSA.

Relasi:

```text
users.id -> peserta.user_id -> sertifikat.peserta_id
```

## Catatan

Cara paling aman adalah menghapus database lama `aslini_db`, membuat ulang database `aslini_db`, lalu import ulang `database/aslini_db.sql`.

File `database/migration_add_users.sql` disediakan sebagai opsi jika ingin menambahkan tabel user ke database lama, tetapi import ulang lebih disarankan agar struktur database bersih.
