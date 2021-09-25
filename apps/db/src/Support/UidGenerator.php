<?php

declare(strict_types=1);

namespace App\Support;

use App\Entity\LivingDex\Pokemon;

class UidGenerator
{
    public function generate(Pokemon $pokemon): int
    {
        if ($pokemon->getIsBaseSpecies()) {
            return $pokemon->getDexNum();
        }

        return 10000 + $pokemon->getDexNum() + $pokemon->getSortingOrder();
    }

    public function generate2(Pokemon $pokemon): string
    {
        $uid = [
            10000 + $pokemon->getDexNum(),
            10000 + $pokemon->getSortingOrder(),
        ];

        if ($pokemon->getIsMaleForm() && $pokemon->isFemaleForm()) {
            $gender = 'mf'; // male or female
        } elseif ($pokemon->getIsMaleForm()) {
            $gender = 'md'; // male diffs
        } elseif ($pokemon->isFemaleForm()) {
            $gender = 'fd'; // female diffs
        } else {
            $gender = 'uk'; // unknown
        }
        $uid[] = (int)base_convert($gender, 36, 10) + 10000;


        $formType = [
            'is_default' => $pokemon->getIsBaseSpecies() ? 1 : 0,
            'is_cosmetic' => $pokemon->isCosmetic() ? 2 : 0,
            'fusion' => $pokemon->isFusion() ? 4 : 0,
            'mega' => $pokemon->isMega() ? 8 : 0,
            'regional' => $pokemon->isRegional() ? 16 : 0,
            'totem' => $pokemon->isTotem() ? 32 : 0,
            'gmax' => $pokemon->isGmax() ? 64 : 0,
            'primal' => $pokemon->isPrimal() ? 128 : 0,
        ];
        $formTypeBits = 0;
        foreach ($formType as $bit) {
            $formTypeBits |= $bit;
        }
        $uid[] = ($formTypeBits + 10000);


        $slug = $pokemon->getFormSlug() ?: $pokemon->getSlug();
        $uid[] = (int)base_convert(substr(strrev($slug), 0, 3), 36, 10) + 10000;

        return implode('-', $uid);
    }
}
