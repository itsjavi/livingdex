<?php

declare(strict_types=1);

namespace App\Support\Serialization;

use Illuminate\Support\Str;

class StrFormat
{
    private const SLUG_SEPARATOR = '-';

    public static function slug($value): string
    {
        return Str::slug((string)$value, self::SLUG_SEPARATOR);
    }

    public static function plainSlug($value): string
    {
        return Str::slug((string)$value, '');
    }

    public static function zeroPadLeft($num, int $padding): string
    {
        return str_pad(ltrim((string)$num, '0'), $padding, '0', STR_PAD_LEFT);
    }
}
