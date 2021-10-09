<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer\Pokemon;

use App\DataSources\Data\VeekunDataMapping;
use App\DataSources\DataSourceException;
use App\DataSources\DataSourceFileIo;
use App\DataSources\Normalizer\DataSourceNormalizer;
use App\Support\Serialization\StrFormat;
use Doctrine\DBAL\Connection;
use Generator;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * Showdown <-> Veekun data conciliator
 */
class VeekunPokemonNormalizer implements DataSourceNormalizer, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private const VEEKUN_ID_FIX = [
        'vivillon-meadow' => 10086,
        'xerneas-active' => 10132,
        'minior-red-meteor' => 10255,
        'vivillon-icy-snow' => 666,
        'xerneas-neutral' => 716,
        'minior-red' => 774,
    ];

    private Connection $veekunConnection;

    private DataSourceFileIo $dataListFileReader;

    public function __construct(Connection $veekunConnection, DataSourceFileIo $dataListFileReader)
    {
        $this->veekunConnection = $veekunConnection;
        $this->dataListFileReader = $dataListFileReader;
    }

    /**
     * @param PokemonContainer[]|\Generator $entries
     * @return Generator|PokemonContainer[]
     * @throws DataSourceException
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function normalize(iterable $entries): Generator
    {
        $veekunMaxPokemonSpeciesId = (int) current(
            $this->veekunConnection->executeQuery(
                "SELECT max(id) as max_id FROM pokemon_species"
            )->fetchFirstColumn()
        );

        $veekunSpeciesList = collect(
            $this->veekunConnection->executeQuery(
                "SELECT * FROM pokemon_species ORDER BY id"
            )->fetchAllAssociative()
        )->keyBy('id')->toArray();

        $veekunForms = collect(
            $this->veekunConnection->executeQuery(
                "SELECT * FROM pokemon ORDER BY id"
            )->fetchAllAssociative()
        )->keyBy('id')->toArray();

        $veekunSubForms = collect(
            $this->veekunConnection->executeQuery(
                "SELECT * FROM pokemon_forms ORDER BY id"
            )->fetchAllAssociative()
        )->keyBy('identifier')->toArray();

        $speciesFixes = $this->dataListFileReader->getAll('fixes/veekun/pokemon_species.json');

        foreach ($entries as $id => $container) {
            $entity = $container->getEntity();

            if ($entity->getDexNum() > $veekunMaxPokemonSpeciesId) {
                yield $id => $container;
                continue;
            }

            $slug = $entity->getSlug();

            $veekunFormSlug = VeekunDataMapping::POKEMON_FORM_SLUGS[$entity->getSlug()] ?? $entity->getSlug();
            $veekunSubFormEntry = $veekunSubForms[$veekunFormSlug] ?? null;

            if ($veekunSubFormEntry === null) {
                $this->logger->warning(
                    "Pokemon Sub-Form not found in veekun DB: {$slug} / Tried with: {$veekunFormSlug}"
                );
                yield $id => $container;
                continue;
            }

            $veekunFormEntry = $veekunForms[$veekunSubFormEntry['pokemon_id']] ?? null;
            if ($veekunFormEntry === null) {
                throw new DataSourceException("Pokemon Form not found in veekun DB: {$slug}");
            }

            $veekunSpeciesEntry = $veekunSpeciesList[$veekunFormEntry['species_id']] ?? null;
            if ($veekunSpeciesEntry === null) {
                throw new DataSourceException("Pokemon Species not found in veekun DB: {$slug}");
            }

            $veekunSpeciesSlugPlain = StrFormat::plainSlug($veekunSpeciesEntry['identifier']);
            $veekunSpeciesEntry = array_merge($veekunSpeciesEntry, $speciesFixes[$veekunSpeciesSlugPlain] ?? []);

            $stats = collect(
                $this->veekunConnection->executeQuery(
                    "SELECT * FROM pokemon_stats WHERE pokemon_id = :pid",
                    ['pid' => $veekunFormEntry['id']]
                )->fetchAllAssociative()
            )->keyBy('stat_id')->toArray();

            if (empty($stats)) {
                throw new DataSourceException("No veekun stats found for {$slug}");
            }

            $entity->setVeekunFormId((int) $veekunSubFormEntry['id'])
                ->setVeekunSlug($veekunSubFormEntry['identifier']);

            $dataEntity = $container->getData();
            if ($dataEntity === null) {
                yield $id => $container;
                continue;
            }

            $dataEntity
                ->setHatchCycles((int) $veekunSpeciesEntry['hatch_counter'])
                ->setCatchRate((int) $veekunSpeciesEntry['capture_rate'])
                ->setBaseFriendship((int) $veekunSpeciesEntry['base_happiness'])
                ->setShape($veekunSpeciesEntry['shape'] ?? VeekunDataMapping::SHAPES[$veekunSpeciesEntry['shape_id']])
                ->setGrowthRate(
                    $veekunSpeciesEntry['growth_rate'] ?? VeekunDataMapping::GROWTH_RATES[$veekunSpeciesEntry['growth_rate_id']]
                )
                ->setYieldBaseExp((int) $veekunFormEntry['base_experience'])
                ->setYieldHp((int) $stats[1]['effort'])
                ->setYieldAttack((int) $stats[2]['effort'])
                ->setYieldDefense((int) $stats[3]['effort'])
                ->setYieldSpAttack((int) $stats[4]['effort'])
                ->setYieldSpDefense((int) $stats[5]['effort'])
                ->setYieldSpeed((int) $stats[6]['effort']);

            yield $id => $container;
        }
    }
}
