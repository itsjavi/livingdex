<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer\Ability;

use App\DataSources\Generation;
use App\DataSources\Normalizer\DataSourceNormalizer;
use App\Entity\LivingDex\Ability;
use App\Support\Serialization\StrFormat;
use Generator;

class ShowdownAbilityNormalizer implements DataSourceNormalizer
{
    /**
     * @param array[] $entries Showdown abilities.json entries
     * @return Generator|Ability[]
     */
    public function normalize(iterable $entries): Generator
    {
        $abilities = [];
        foreach ($entries as $entryKey => $entry) {
            if ((($entry['isNonstandard'] ?? null) === 'CAP') || (($entry['num'] ?? 0) <= 0)) {
                continue;
            }

            $ratingOver5 = (float)($entry['rating'] ?? -5);
            $ratingPercent = (int)(($ratingOver5 * 100) / 5);

            $slug = StrFormat::slug($entry['name']);
            $entity = new Ability();
            $entity->setId((int)$entry['num']);
            $entity->setGen(Generation::MAX_GEN);
            $entity->setName($entry['name']);
            $entity->setSlug($slug);
            $entity->setRating($ratingPercent);
            $entity->setShowdownName($entry['name']);

            $abilities[$entity->getId()] = $entity;
        }

        ksort($abilities);
        yield from $abilities;
    }
}
