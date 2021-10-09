<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer\Pokemon;

use App\DataSources\DataSourceException;
use App\DataSources\DataSourceFileIo;
use App\DataSources\Generation;
use App\DataSources\Normalizer\DataSourceNormalizer;
use App\Entity\LivingDex\Ability;
use App\Repository\LivingDex\AbilityRepository;
use App\Support\Serialization\StrFormat;
use App\Support\Types\ArrayProxy;
use Illuminate\Support\Arr;

class ShowdownPokemonNormalizer implements DataSourceNormalizer
{
    private const INITIAL_MAX_FORM_ID = 10000;

    private DataSourceFileIo $localDataSource;
    private AbilityRepository $abilityRepository;
    private int $maxFormId = self::INITIAL_MAX_FORM_ID;
    private array $extraData;

    public function __construct(
        DataSourceFileIo $dataListFileReader,
        AbilityRepository $abilityRepository
    ) {
        $this->localDataSource = $dataListFileReader;
        $this->abilityRepository = $abilityRepository;
    }

    /**
     * @param array[] $entries Showdown pokedex.json entries
     * @return \Generator|PokemonContainer[]
     * @throws DataSourceException
     */
    public function normalize(iterable $entries): \Generator
    {
        $containers = [];
        $containersById = [];
        $entries = $this->applyFixes($entries);
        $this->extraData = $this->localDataSource->getAll('meta/pokemon.json');

        // normalize array to container
        foreach ($entries as $alias => $entry) {
            $entry['_alias'] = $alias;
            $normalizedEntries = $this->normalizeArray($entry);
            foreach ($normalizedEntries as $normalizedEntry) {
                $container = $this->normalizeAsContainer($normalizedEntry);
                $containers[$container->getEntity()->getSlug()] = $container;
            }
        }

        // set base species
        foreach ($containers as $slug => $container) {
            $baseSpeciesSlug = $container->getShowdownData()['_baseSpeciesSlug'];
            if ($baseSpeciesSlug === null) {
                $containersById[$container->getEntity()->getId()] = $container;
                continue;
            }
            $baseSpecies = $containers[$baseSpeciesSlug] ?? null;
            if ($baseSpecies === null) {
                throw new DataSourceException("Base species entry '{$baseSpeciesSlug}' not found for {$slug}");
            }

            $container->getEntity()->setBaseSpecies($baseSpecies->getEntity());

            $containersById[$container->getEntity()->getId()] = $container;
        }

        $abilities = $this->abilityRepository->findAll();
        $abilitiesBySlug = [];
        foreach ($abilities as $ability) {
            $abilitiesBySlug[$ability->getSlug()] = $ability;
        }

        // add data
        foreach ($containersById as $id => $container) {
            $baseDataForm = $this->getExtraData($container->getSlug(), 'base_species');
            if ($baseDataForm !== null) {
                $baseSpeciesId = $container->getEntity()->getBaseSpecies()->getId();
                $container->getEntity()->setBaseSpecies($containersById[$baseSpeciesId]->getEntity());
                // continue;
            }
            if (!$this->getExtraData($container->getSlug(), 'is_cosmetic')) {
                $this->normalizeData($container, $abilitiesBySlug);
            }
        }

        // set proper slug
        foreach ($containersById as $id => $container) {
            $slug = $this->getExtraData($container->getSlug(), 'slug');
            $container->getEntity()->setSlug($slug);
        }

        ksort($containersById);

        yield from $containersById;
    }

    private function applyFixes(array $data): array
    {
        $fixes = $this->localDataSource->getAll('fixes/showdown/pokedex.json');
        $fixedData = $data;
        foreach ($fixes as $showdownSlug => $override) {
            if (!isset($data[$showdownSlug])) {
                throw new DataSourceException("Entry for {$showdownSlug} not found in original Showdown data.");
            }
            $fixedData[$showdownSlug] = array_replace_recursive($data[$showdownSlug] ?? [], $override);
        }

        return $fixedData;
    }

    private function getExtraData(string $slug, string $path, $default = null)
    {
        $slugPlain = StrFormat::plainSlug($slug);

        $poke = $this->extraData[$slugPlain] ?? null;
        if ($poke === null) {
            throw new DataSourceException("Extra data not found for {$slugPlain}");
        }
        if (!Arr::exists($poke, $path)) {
            throw new DataSourceException("Extra data field not found: {$slugPlain}.{$path}");
        }

        return Arr::get($poke, $path, $default);
    }

    private function normalizeAsContainer(array $data): PokemonContainer
    {
        $container = new PokemonContainer($data);
        $entity = $container->getEntity();

        $dexNum = (int) $data['num'];
        $slug = $data['_slug'];
        $formSlug = $data['_formSlug'];
        $baseSpeciesSlug = $data['_baseSpeciesSlug'];

        if ($baseSpeciesSlug === null) {
            $id = $dexNum;
        } else {
            ++$this->maxFormId;
            $id = $this->maxFormId;
        }

        $entity
            ->setId($id)
            ->setDexNum($dexNum)
            ->setSlug(StrFormat::plainSlug($slug))
            ->setName($data['name'])
            ->setFormSlug($formSlug)
            ->setFormName($data['_formName'])
            ->setBaseSpecies(null)
            ->setShowdownSlug($data['_alias'])
            ->setVeekunSlug(null)
            ->setVeekunFormId(null);

        return $container;
    }

    /**
     * @param PokemonContainer $container
     * @param Ability[]        $abilitiesBySlug
     * @throws DataSourceException
     */
    private function normalizeData(PokemonContainer $container, array $abilitiesBySlug)
    {
        $data = $container->createData();
        $dataSrc = new ArrayProxy($container->getShowdownData());

        $ability1 = $dataSrc->getSlug('abilities.0');
        if ($ability1 !== null && !isset($abilitiesBySlug[$ability1])) {
            throw new DataSourceException("Ability not found {$ability1}");
        }
        $ability2 = $dataSrc->getSlug('abilities.1');
        if ($ability2 !== null && !isset($abilitiesBySlug[$ability2])) {
            throw new DataSourceException("Ability not found {$ability2}");
        }
        $abilityHidden = $dataSrc->getSlug('abilities.H');
        if ($abilityHidden !== null && !isset($abilitiesBySlug[$abilityHidden])) {
            throw new DataSourceException("Ability not found {$abilityHidden}");
        }

        $genderRatio = $this->getGenderRatio($container->getShowdownData());

        $data->setGen(Generation::MAX_GEN)
            ->setType1($dataSrc->getSlug('types.0'))
            ->setType2($dataSrc->getSlug('types.1'))
            ->setEggGroup1($dataSrc->getSlug('eggGroups.0'))
            ->setEggGroup2($dataSrc->getSlug('eggGroups.1'))
            ->setAbility1($ability1 ? $abilitiesBySlug[$ability1] : null)
            ->setAbility2($ability2 ? $abilitiesBySlug[$ability2] : null)
            ->setAbilityHidden($abilityHidden ? $abilitiesBySlug[$abilityHidden] : null)
            ->setHeight((int) ($dataSrc->getFloat('heightm', -0.01) * 100))
            ->setWeight((int) ($dataSrc->getFloat('weightkg', -0.01) * 100))
            ->setColor($dataSrc->getSlug('color'))
            ->setActualColor($dataSrc->getSlug('color'))
            ->setMaleRatio($genderRatio['male'])
            ->setFemaleRatio($genderRatio['female'])
            ->setBaseHp($dataSrc->getInt('baseStats.hp', -1))
            ->setBaseAttack($dataSrc->getInt('baseStats.atk', -1))
            ->setBaseDefense($dataSrc->getInt('baseStats.def', -1))
            ->setBaseSpAttack($dataSrc->getInt('baseStats.spa', -1))
            ->setBaseSpDefense($dataSrc->getInt('baseStats.spd', -1))
            ->setBaseSpeed($dataSrc->getInt('baseStats.spe', -1))
            ->setShape('?')
            ->setGrowthRate('?')
            ->setCatchRate(-1)
            ->setHatchCycles(-1)
            ->setBaseFriendship(-1)
            ->setYieldBaseExp(-1)
            ->setYieldHp(-1)
            ->setYieldAttack(-1)
            ->setYieldDefense(-1)
            ->setYieldSpAttack(-1)
            ->setYieldSpDefense(-1)
            ->setYieldSpeed(-1);
    }

    /**
     * Normalizes the Showdown Pokemon entry and returns
     * an array having that entry, none or more than one.
     *
     * Useful for creating missing entries.
     *
     * @param array $poke
     * @return array
     */
    private function normalizeArray(array $poke): array
    {
        if ($poke['num'] <= 0) {
            return [];
        }

        $poke['_slug'] = StrFormat::slug($poke['name']);
        $femaleForms = $this->expandFemaleCosmeticForms($poke);
        $cosmeticForms = $this->expandCosmeticForms($poke);
        $spAbilityForms = $this->expandSpecialAbilityForms($poke);

        $extraForms = array_merge([$poke], $femaleForms, $cosmeticForms, $spAbilityForms);

        // update slugs and other data for all entries
        foreach ($extraForms as $k => $entry) {
            $slug = StrFormat::slug($entry['name']);
            $entry['_slug'] = $slug;
            $entry['_formName'] = ($entry['forme'] ?? null) ?: ($entry['baseForme'] ?? null);
            $entry['_formSlug'] = $entry['_formName'] ? StrFormat::slug($entry['_formName']) : null;

            $baseSpeciesSlug = $this->getExtraData($slug, 'base_species', false);
            if ($baseSpeciesSlug === false) {
                throw new DataSourceException("base_species data not set for {$slug}");
            }
            $entry['_baseSpeciesSlug'] = $baseSpeciesSlug ? StrFormat::plainSlug($baseSpeciesSlug) : $baseSpeciesSlug;

            $extraForms[$k] = $entry;
        }

        return $extraForms;
    }

    private function expandSpecialAbilityForms(array $poke): array
    {
        $extraForms = [];

        // add special-ability pokes as separate form
        if (isset($poke['abilities']['S'])) {
            $spAbilityPoke = $poke;
            $spAbilityPoke['baseSpecies'] = $poke['baseSpecies'] ?? $poke['name'];
            $spAbilityPoke['name'] .= '-' . str_replace(' ', '-', $poke['abilities']['S']);
            $spAbilityPoke['forme'] = str_replace($poke['name'] . '-', '', $spAbilityPoke['name']);
            $spAbilityPoke['abilities'] = [
                "0" => $poke['abilities']['S'],
            ];
            $extraForms[] = $spAbilityPoke;
        }

        return $extraForms;
    }

    private function expandCosmeticForms(array $poke): array
    {
        $extraForms = [];
        $subCosmeticForms = [''];
        $cosmeticForms = $poke['cosmeticFormes'] ?? [];

        foreach ($cosmeticForms as $cosmeticFormeFullName) {
            foreach ($subCosmeticForms as $subCosmeticForme) {
                $subCosmeticFormeFullName = $cosmeticFormeFullName . $subCosmeticForme;
                $cosmeticPoke = $poke;
                $cosmeticPoke['baseSpecies'] = $poke['baseSpecies'] ?? $poke['name'];
                $cosmeticPoke['name'] = $subCosmeticFormeFullName;
                $cosmeticPoke['forme'] = str_replace($poke['name'] . '-', '', $subCosmeticFormeFullName);
                $cosmeticPoke['cosmeticFormes'] = [];
                $extraForms[] = $cosmeticPoke;
            }
        }

        return $extraForms;
    }

    private function expandFemaleCosmeticForms(array $poke): array
    {
        $extraForms = [];

        // add female cosmetic variant if isn't already in the dataset
        if (
            array_key_exists($poke['_slug'] . 'f', $this->extraData)
            && $this->getExtraData($poke['_slug'], 'has_gender_diffs')
            && $this->getExtraData($poke['_slug'] . 'f', 'is_cosmetic')
        ) {
            $femalePoke = $poke;
            $femalePoke['name'] .= '-F';
            $femalePoke['forme'] = 'F';
            $femalePoke['baseSpecies'] = $poke['baseSpecies'] ?? $poke['name'];
            $femalePoke['_alias'] = null;

            $extraForms[] = $femalePoke;
        }

        return $extraForms;
    }

    private function getGenderRatio(array $poke): array
    {
        $genderRatio = [];
        $dataGender = $poke['gender'] ?? null;

        // gender ratio
        if ($dataGender === 'M') {
            $genderRatio['male'] = 1.0;
            $genderRatio['female'] = 0.0;
        } elseif ($dataGender === 'F') {
            $genderRatio['male'] = 0.0;
            $genderRatio['female'] = 1.0;
        } elseif ($dataGender === 'N') {
            $genderRatio['male'] = 0.0;
            $genderRatio['female'] = 0.0;
        } else {
            $genderRatio['male'] = $poke['genderRatio']['M'] ?? 0.5;
            $genderRatio['female'] = $poke['genderRatio']['F'] ?? 0.5;
        }

        return ['male' => (int) $genderRatio['male'] * 100, 'female' => (int) $genderRatio['female'] * 100];
    }
}
