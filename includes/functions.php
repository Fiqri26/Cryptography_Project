<?php
function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function statusClass($status) {
    return match ($status) {
        'terkirim' => 'status-success',
        'ditandatangani' => 'status-purple',
        default => 'status-warning',
    };
}

function statusText($status) {
    return match ($status) {
        'terkirim' => 'Terkirim',
        'ditandatangani' => 'Ditandatangani',
        default => 'Pending',
    };
}

function formatTanggalIndo($dateString) {
    if (!$dateString) {
        return '-';
    }

    $bulan = [
        1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
        'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    ];

    $timestamp = strtotime($dateString);
    if (!$timestamp) {
        return $dateString;
    }

    $day = date('j', $timestamp);
    $month = $bulan[(int) date('n', $timestamp)];
    $year = date('Y', $timestamp);

    return "{$day} {$month} {$year}";
}

function adminInitials($name) {
    $words = preg_split('/\s+/', trim((string) $name));
    $initials = '';
    foreach ($words as $word) {
        if ($word !== '') {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        if (strlen($initials) >= 2) {
            break;
        }
    }
    return $initials ?: 'AD';
}
