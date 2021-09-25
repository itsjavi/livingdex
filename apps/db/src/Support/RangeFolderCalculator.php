<?php

declare(strict_types=1);

namespace App\Support;

use App\Support\Serialization\StrFormat;

class RangeFolderCalculator
{
    public function calculate($num, int $zeroPadding = 4, int $itemsPerFolder = 100): string
    {
        $num = (int)$num;
        $minFolder = null;
        $maxFolder = null;

        for ($i = 0; $i < $num + ($itemsPerFolder * 2); $i += $itemsPerFolder) {
            if ($minFolder === null && (($i + $itemsPerFolder) >= $num)) {
                $minFolder = ($i + 1);
                $maxFolder = $i + $itemsPerFolder;
                break;
            }
        }

        return StrFormat::zeroPadLeft($minFolder, $zeroPadding) . '-' . StrFormat::zeroPadLeft($maxFolder, $zeroPadding);
    }
}
