<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer\GameGroup;

use App\DataSources\DataSourceFileIo;
use App\DataSources\Normalizer\DataSourceNormalizerPipeline;
use App\Entity\LivingDex\GameGroup;
use Doctrine\ORM\EntityManagerInterface;

class GameGroupNormalizerPipeline implements DataSourceNormalizerPipeline
{
    private DataSourceFileIo $localDataSource;

    private EntityManagerInterface $entityManager;

    public function __construct(DataSourceFileIo $dataListFileReader, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->localDataSource = $dataListFileReader;
    }

    public function normalize(): \Generator
    {
        $csvData = $this->localDataSource->getAll('table-inserts/game_groups.csv');
        $gameGroups = [];

        foreach ($csvData as $gameGroup) {
            /** @var GameGroup|null $gameGroupRef */
            $gameGroupRef = $gameGroup['base_game_group_id'] ? $this->entityManager->getReference(
                GameGroup::class,
                (int)$gameGroup['base_game_group_id']
            ) : null;

            $id = (int)$gameGroup['id'];

            $gameGroups[$id] = (new GameGroup())
                ->setId($id)
                ->setGen((int)$gameGroup['gen'])
                ->setSlug($gameGroup['slug'])
                ->setName($gameGroup['name'])
                ->setSortingOrder((int)$gameGroup['sorting_order'])
                ->setRegion($gameGroup['region'] ?: null)
                ->setBaseGameGroup($gameGroupRef)
                ->setReleaseDate(new \DateTimeImmutable($gameGroup['release_date'] . ' 00:00:00'));
        }

        ksort($gameGroups);

        yield from $gameGroups;
    }
}
