<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer;

use Generator;

interface DataSourceNormalizer
{
    public function normalize(iterable $entries): Generator;
}
