<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer\Pokemon;

use App\DataSources\DataSourceException;
use App\DataSources\DataSourceFileIo;
use App\DataSources\Normalizer\DataSourceNormalizerPipeline;
use App\Support\Serialization\Encoder\JsonEncoder;
use App\Support\Serialization\StrFormat;
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
    )
    {
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

        $overrides = $this->localDataSource->getAll('meta/pokemon.json');

        foreach ($entries as $k => $entry) {
            $this->applyOverrides($overrides, $entry);
            $this->applySortingOrder($overrides, $entry);
            yield $k => $entry;
        }
    }

    private function applySortingOrder(array $overrides, PokemonContainer $container): void
    {
        $formsSortingOrder = [];
        foreach ($overrides as $plainSlug => $data) {
            if ($data['forms_order'] === null) {
                continue;
            }
            foreach ($data['forms_order'] as $order => $formSlug) {
                $formSlugPlain = StrFormat::plainSlug($formSlug);
                if (isset($formsSortingOrder[$formSlugPlain])) {
                    throw new DataSourceException("Duplicated entry for {$formSlug} found in {$plainSlug}.forms_order");
                }
                $formsSortingOrder[$formSlugPlain] = $order;
            }
        }

        $slugPlain = StrFormat::plainSlug($container->getEntity()->getSlug());
        if (!isset($formsSortingOrder[$slugPlain])) {
            throw new DataSourceException("Not sorting order found for {$slugPlain}");
        }
        $container->getEntity()->setSortingOrder($formsSortingOrder[$slugPlain]);
    }

    private function applyOverrides(array $overrides, PokemonContainer $container): void
    {
        $setters = [
            'gen' => 'setGen',
            'region' => 'setRegion',
            'name' => 'setName',
            'form_name' => 'setFormName',
            'slug' => 'setSlug',
            'slug_aliases' => 'setSlugAliases',
            'form_slug' => 'setFormSlug',
            'is_cosmetic' => 'setIsCosmetic',
            'has_gender_diffs' => 'setHasGenderDiffs',
            'is_female' => 'setIsFemale',
            'is_battle_only' => 'setIsBattleOnly',
            'is_reversible' => 'setIsReversible',
            'is_fusion' => 'setIsFusion',
            'can_dynamax' => 'setCanDynamax',
            'is_gmax' => 'setIsGmax',
            'is_legendary' => 'setIsLegendary',
            'is_mythical' => 'setIsMythical',
            'is_mega' => 'setIsMega',
            'is_primal' => 'setIsPrimal',
            'is_totem' => 'setIsTotem',
            'is_ability_form' => 'setIsAbilityForm',
            'is_regional' => 'setIsRegional',
            'is_home_storable' => 'setIsHomeStorable',
            'is_home_registrable' => 'setIsHomeRegistrable',
            'is_default' => null,
            'is_form' => null,
            'base_species' => null,
            'base_forms' => null,
            'forms_order' => null,
            'fused_pokemon' => null,
            'images' => null,
        ];

        $entity = $container->getEntity();
        $slug = StrFormat::plainSlug($entity->getSlug());

        if (!array_key_exists($slug, $overrides)) {
            throw new DataSourceException("Metadata entry not found for {$slug}");
        }

        $singleOverrides = $overrides[$slug];

        foreach ($singleOverrides as $field => $value) {
            if (!array_key_exists($field, $setters)) {
                throw new DataSourceException("Metadata field '{$field}' has no configured setter in " . static::class);
            }

            if ($setters[$field] === null) { // skip
                continue;
            }

            $setterMethod = $setters[$field];

            if (!method_exists($entity, $setterMethod)) {
                throw new DataSourceException("Metadata setter for field '{$field}' does not exist: {$setterMethod}");
            }

            if ($value === null || $value === []) {
                // continue; // uncomment to not set null/empty-array values
            }

            $entity->{$setterMethod}($value);

            // TODO: add setters for 'data' entry
            // TODO: add setters for 'form' entry
        }
    }
}
