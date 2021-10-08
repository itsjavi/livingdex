<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer\Pokemon;

use App\DataSources\DataSourceException;
use App\DataSources\DataSourceFileIo;
use App\DataSources\Normalizer\DataSourceNormalizerPipeline;
use App\Support\Serialization\Encoder\JsonEncoder;
use Illuminate\Support\Str;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class PokemonNormalizerPipeline implements DataSourceNormalizerPipeline, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private string $showdownDataDir;
    private ShowdownPokemonNormalizer $showdownPokemonNormalizer;
    private VeekunPokemonNormalizer $veekunPokemonNormalizer;
    private DataSourceFileIo $localDataSource;

    public function __construct(
        string $showdownDataDir,
        ShowdownPokemonNormalizer $showdownPokemonNormalizer,
        VeekunPokemonNormalizer $veekunPokemonNormalizer,
        DataSourceFileIo $localDataSource
    ) {
        $this->showdownPokemonNormalizer = $showdownPokemonNormalizer;
        $this->showdownDataDir = $showdownDataDir;
        $this->veekunPokemonNormalizer = $veekunPokemonNormalizer;
        $this->localDataSource = $localDataSource;
    }

    /**
     * @return PokemonContainer[]
     */
    public function normalize(): \Generator
    {
        $entriesRaw = JsonEncoder::decodeFile($this->showdownDataDir . '/pokedex.json', 'Pokedex');
        $entries = $this->veekunPokemonNormalizer
            ->normalize(
                $this->showdownPokemonNormalizer->normalize($entriesRaw)
            );

        $extras = $this->localDataSource->getAll('meta/pokemon.json');

        foreach ($entries as $k => $entry) {
            $this->addHomeStorability($entry);
            $this->addPokemonExtrasUpdates($extras, $entry);
            yield $k => $entry;
        }
    }

    private function addHomeStorability(PokemonContainer $container): void
    {
        $container->getEntity()->setIsHomeStorable(
            !$this->localDataSource->contains(
                $container->getEntity()->getSlug(),
                'meta/pokemon-home-non-storable.json'
            )
        );
    }

    private function addPokemonExtrasUpdates(array $extras, PokemonContainer $container): void
    {
        $allowedFields = [
            //"is_battle_only",
            "can_dynamax",
            "is_cosmetic",
            "is_fusion",
            //"fused_pokemon",
            //"has_gender_diffs",
            //"is_reversible",
            "is_legendary",
            "is_mythical",
            //"base_species",
            //"changes_from",
            "img_home",
            "img_sprite",
            "catch_rate",
            "base_friendship",
            "shape",
            "growth_rate",
            "yield_base_exp",
            "yield_stats",
            "hatch_cycles",
        ];

        $entity = $container->getEntity();
        $data = $container->getData();

        $slug = $entity->getSlug();
        if (!array_key_exists($slug, $extras)) {
            throw new DataSourceException("pokemon.json extras doesn't have an entry for {$slug}");
        }
        $extras = $extras[$slug];

        foreach ($extras as $field => $value) {
            if ($value === null || !in_array($field, $allowedFields, true)) {
                continue;
            }

            $setterMethod = 'set' . ucfirst(Str::camel($field));

            if (method_exists($entity, $setterMethod)) {
                $entity->{$setterMethod}($value);
                continue;
            }

            if ($data === null) {
                continue;
            }

            $genIndex = 'gen-' . $data->getGen();

            if (is_array($value) && isset($value[$genIndex])) {
                if ($field === 'yield_stats' && is_array($value[$genIndex])) {
                    $value = $value[$genIndex];
                    array_map(
                        function ($val) use ($slug) {
                            if (!is_int($val)) {
                                throw new DataSourceException(
                                    "{$slug}: Yield stats should be an array of 6 integers from 0 to 3."
                                );
                            }
                        },
                        $value
                    );
                    [$hp, $atk, $def, $spa, $spd, $spe] = $value;
                    $data->setYieldHp($hp);
                    $data->setYieldAttack($atk);
                    $data->setYieldDefense($def);
                    $data->setYieldSpAttack($spa);
                    $data->setYieldSpDefense($spd);
                    $data->setYieldSpeed($spe);
                    continue;
                }

                if (method_exists($data, $setterMethod)) {
                    $data->{$setterMethod}($value[$genIndex]);
                    continue;
                }

                throw new DataSourceException(
                    "Gen-based data cannot be set for {$slug}.{$field}. Value is: " .
                    var_export($value, true)
                );
            } else {
                throw new DataSourceException(
                    "Gen-based data not found for {$slug}.{$field}. Missing {$genIndex} key. Value is: " .
                    var_export($value, true)
                );
            }
            // TODO: add setters for form entry
        }
    }
}
