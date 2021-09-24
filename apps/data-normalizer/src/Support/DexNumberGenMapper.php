<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Tool to map a dex number to a generation
 */
class DexNumberGenMapper
{
    public const GENERATION_DEX_RANGES = [
        1 => [1, 151],
        2 => [152, 251],
        3 => [252, 386],
        4 => [387, 493],
        5 => [494, 649],
        6 => [650, 721],
        7 => [722, 809],
        8 => [810, 898],
    ];

    public function getGenerationByDexNum(int $dexNum): int
    {
        foreach (self::GENERATION_DEX_RANGES as $gen => $dexRange) {
            [$min, $max] = $dexRange;
            if ($dexNum >= $min && $dexNum <= $max) {
                return $gen;
            }
        }

        return 0;
    }
}
