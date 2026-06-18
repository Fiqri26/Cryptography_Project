<?php
require_once __DIR__ . '/sha256.php';

if (!defined('ASLINI_PRIVATE_KEY_PATH')) {
    define('ASLINI_PRIVATE_KEY_PATH', __DIR__ . '/private_key.pem');
}

if (!defined('ASLINI_PUBLIC_KEY_PATH')) {
    define('ASLINI_PUBLIC_KEY_PATH', __DIR__ . '/public_key.pem');
}

if (!function_exists('aslini_ensure_rsa_key_pair')) {
    function aslini_ensure_rsa_key_pair(): void
    {
        if (is_file(ASLINI_PRIVATE_KEY_PATH) && is_file(ASLINI_PUBLIC_KEY_PATH)) {
            return;
        }

        $config = [
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ];

        $privateKey = openssl_pkey_new($config);
        if ($privateKey === false) {
            throw new RuntimeException('Gagal membuat RSA key pair.');
        }

        $privatePem = '';
        if (!openssl_pkey_export($privateKey, $privatePem)) {
            throw new RuntimeException('Gagal mengekspor private key RSA.');
        }

        $details = openssl_pkey_get_details($privateKey);
        if (!$details || empty($details['key'])) {
            throw new RuntimeException('Gagal mengambil public key RSA.');
        }

        if (!is_dir(__DIR__)) {
            mkdir(__DIR__, 0775, true);
        }

        file_put_contents(ASLINI_PRIVATE_KEY_PATH, $privatePem);
        file_put_contents(ASLINI_PUBLIC_KEY_PATH, $details['key']);
    }
}

if (!function_exists('aslini_private_key')) {
    function aslini_private_key()
    {
        aslini_ensure_rsa_key_pair();

        $privateKey = openssl_pkey_get_private(file_get_contents(ASLINI_PRIVATE_KEY_PATH));
        if ($privateKey === false) {
            throw new RuntimeException('Private key RSA tidak valid.');
        }

        return $privateKey;
    }
}

if (!function_exists('aslini_public_key')) {
    function aslini_public_key()
    {
        aslini_ensure_rsa_key_pair();

        $publicKey = openssl_pkey_get_public(file_get_contents(ASLINI_PUBLIC_KEY_PATH));
        if ($publicKey === false) {
            throw new RuntimeException('Public key RSA tidak valid.');
        }

        return $publicKey;
    }
}

if (!function_exists('aslini_sign_hash')) {
    function aslini_sign_hash(string $sha256Hash): string
    {
        if (!aslini_is_sha256_hash($sha256Hash)) {
            throw new InvalidArgumentException('Nilai hash SHA-256 tidak valid.');
        }

        $signature = '';
        $signed = openssl_sign($sha256Hash, $signature, aslini_private_key(), OPENSSL_ALGO_SHA256);
        if (!$signed) {
            throw new RuntimeException('Gagal membuat digital signature RSA.');
        }

        return base64_encode($signature);
    }
}

if (!function_exists('aslini_verify_hash_signature')) {
    function aslini_verify_hash_signature(string $sha256Hash, ?string $signature): bool
    {
        if (!aslini_is_sha256_hash($sha256Hash) || $signature === null || trim($signature) === '') {
            return false;
        }

        $decodedSignature = base64_decode($signature, true);
        if ($decodedSignature === false) {
            return false;
        }

        return openssl_verify($sha256Hash, $decodedSignature, aslini_public_key(), OPENSSL_ALGO_SHA256) === 1;
    }
}
