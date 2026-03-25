<?php

namespace App\Traits;

trait HasTaskStatuses
{
    public static function allowedStatuses(): array
    {
        return [
            'chua_lam',
            'dang_lam',
            'hoan_thanh',
        ];
    }

    public static function statusLabel(?string $status): string
    {
        return match ($status) {
            'chua_lam' => 'Not Started',
            'dang_lam' => 'In Progress',
            'hoan_thanh' => 'Completed',
            default => 'Unknown',
        };
    }
}

