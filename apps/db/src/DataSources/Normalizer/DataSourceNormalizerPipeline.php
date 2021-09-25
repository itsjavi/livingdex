<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer;

use Generator;

interface DataSourceNormalizerPipeline
{
    public function normalize(): Generator;
}
