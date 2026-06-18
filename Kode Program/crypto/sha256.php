<?php
if (!function_exists('aslini_sha256_file')) {
    function aslini_sha256_file(string $filePath): string
    {
        if (!is_file($filePath) || !is_readable($filePath)) {
            throw new RuntimeException('File sertifikat tidak dapat dibaca.');
        }

        $hash = hash_file('sha256', $filePath);
        if ($hash === false) {
            throw new RuntimeException('Gagal menghitung SHA-256 file sertifikat.');
        }

        return $hash;
    }
}

if (!function_exists('aslini_sha256_data')) {
    function aslini_sha256_data(string $data): string
    {
        return hash('sha256', $data);
    }
}

if (!function_exists('aslini_is_sha256_hash')) {
    function aslini_is_sha256_hash(string $hash): bool
    {
        return preg_match('/^[a-f0-9]{64}$/i', $hash) === 1;
    }
}
