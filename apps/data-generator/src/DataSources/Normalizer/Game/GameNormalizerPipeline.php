<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer\Game;

use App\DataSources\DataSourceFileIo;
use App\DataSources\Normalizer\DataSourceNormalizerPipeline;
use App\Entity\LivingDex\Game;
use App\Entity\LivingDex\GameGroup;
use Doctrine\ORM\EntityManagerInterface;

class GameNormalizerPipeline implements DataSourceNormalizerPipeline
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
        $csvData = $this->localDataSource->getAll('table-inserts/games.csv');
        $games = [];

        foreach ($csvData as $game) {
            /** @var GameGroup $gameGroupRef */
            $gameGroupRef = $this->entityManager->getReference(
                GameGroup::class,
                (int)$game['game_group_id']
            );

            $id = (int)$game['id'];
            $games[$id] = (new Game())
                ->setId($id)
                ->setGen((int)$game['gen'])
                ->setGameGroup($gameGroupRef)
                ->setSlug($game['slug'])
                ->setName($game['name'])
                ->setSortingOrder((int)$game['sorting_order']);
        }

        ksort($games);

        yield from $games;
    }
}
