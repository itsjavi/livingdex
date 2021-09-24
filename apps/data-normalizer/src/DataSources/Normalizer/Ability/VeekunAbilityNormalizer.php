<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer\Ability;

use App\DataSources\Normalizer\DataSourceNormalizer;
use App\Entity\LivingDex\Ability;
use Doctrine\DBAL\Connection;
use Generator;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * Showdown <-> Veekun data conciliator
 */
class VeekunAbilityNormalizer implements DataSourceNormalizer, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private Connection $veekunConnection;

    public function __construct(
        Connection $veekunConnection
    ) {
        $this->veekunConnection = $veekunConnection;
    }

    /**
     * @param Ability[] $entries
     * @return Generator|Ability[]
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function normalize(iterable $entries): Generator
    {
        $veekunMaxAbilityId = (int)current(
            $this->veekunConnection->executeQuery(
                "SELECT max(id) as max_id FROM abilities WHERE is_main_series = 1"
            )->fetchFirstColumn()
        );

        $this->logger->info("Max veekun ability ID = {$veekunMaxAbilityId}");

        foreach ($entries as $entryKey => $entity) {
            if ($entity->getId() > $veekunMaxAbilityId) {
                yield $entryKey => $entity;
                continue;
            }

            $slug = $entity->getSlug();

            $veekunEntry = $this->veekunConnection->executeQuery(
                "SELECT * FROM abilities WHERE identifier = :slug AND is_main_series = 1",
                ['slug' => $slug]
            )->fetchAssociative();

            // Run some checks

            if (!is_array($veekunEntry)) {
                $this->logger->warning("Ability not found in veekun DB: {$slug} ID={$entity->getId()}");
                yield $slug => $entity;
                continue;
            }

            $veekunId = (int)$veekunEntry['id'];
            if ($veekunId !== $entity->getId()) {
                $this->logger->warning(
                    "Ability IDs are different for {$slug}: showdown={$entity->getId()}, veekun={$veekunId}"
                );
            }

            // Set missing fields
            $entity->setGen((int)$veekunEntry['generation_id']);
            $entity->setVeekunName($veekunEntry['identifier']);

            yield $entryKey => $entity;
        }
    }
}
