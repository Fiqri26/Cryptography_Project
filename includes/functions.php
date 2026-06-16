<?php
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function statusClass(string $status): string {
    return match ($status) {
        'terkirim' => 'status-success',
        'ditandatangani' => 'status-purple',
        default => 'status-warning',
    };
}

function statusText(string $status): string {
    return match ($status) {
        'terkirim' => 'Terkirim',
        'ditandatangani' => 'Ditandatangani',
        default => 'Pending',
    };
}

function formatTanggalIndo(string $dateString): string {
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

function adminInitials(string $name): string {
    $words = preg_split('/\s+/', trim($name));
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
