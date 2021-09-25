<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer\Ability;

use App\DataSources\Normalizer\DataSourceNormalizerPipeline;
use App\Entity\LivingDex\Ability;
use App\Support\Serialization\Encoder\JsonEncoder;
use Generator;

class AbilityNormalizerPipeline implements DataSourceNormalizerPipeline
{
    private string $showdownDataDir;
    private ShowdownAbilityNormalizer $showdownAbilityNormalizer;
    private VeekunAbilityNormalizer $veekunAbilityNormalizer;

    public function __construct(
        string $showdownDataDir,
        ShowdownAbilityNormalizer $showdownAbilityNormalizer,
        VeekunAbilityNormalizer $veekunAbilityNormalizer
    ) {
        $this->showdownAbilityNormalizer = $showdownAbilityNormalizer;
        $this->showdownDataDir = $showdownDataDir;
        $this->veekunAbilityNormalizer = $veekunAbilityNormalizer;
    }

    /**
     * @return Generator|Ability[]
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function normalize(): Generator
    {
        $dataset = JsonEncoder::decodeFile($this->showdownDataDir . '/abilities.json', 'Abilities');

        yield from $this->veekunAbilityNormalizer
            ->normalize(
                $this->showdownAbilityNormalizer->normalize($dataset)
            );
    }
}
