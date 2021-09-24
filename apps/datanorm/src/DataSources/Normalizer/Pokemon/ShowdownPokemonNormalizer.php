<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer\Pokemon;

use App\DataSources\DataSourceException;
use App\DataSources\DataSourceFileIo;
use App\DataSources\DataSourceFileIoException;
use App\DataSources\Generation;
use App\DataSources\Normalizer\DataSourceNormalizer;
use App\DataSources\Normalizer\Region\RegionEnum;
use App\Entity\LivingDex\Ability;
use App\Repository\LivingDex\AbilityRepository;
use App\Support\DexNumberGenMapper;
use App\Support\RangeFolderCalculator;
use App\Support\Serialization\StrFormat;
use App\Support\Types\ArrayProxy;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ShowdownPokemonNormalizer implements DataSourceNormalizer
{
    private const INITIAL_MAX_FORM_ID = 10000;

    private DexNumberGenMapper $dexNumberGenMapper;
    private DataSourceFileIo $localDataSource;
    private RangeFolderCalculator $rangeFolderCalculator;
    private AbilityRepository $abilityRepository;
    private int $maxFormId = self::INITIAL_MAX_FORM_ID;
    private array $extraData;

    public function __construct(
        DexNumberGenMapper $dexNumberGenMapper,
        DataSourceFileIo $dataListFileReader,
        RangeFolderCalculator $rangeFolderCalculator,
        AbilityRepository $abilityRepository
    ) {
        $this->dexNumberGenMapper = $dexNumberGenMapper;
        $this->localDataSource = $dataListFileReader;
        $this->rangeFolderCalculator = $rangeFolderCalculator;
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
        $this->extraData = $this->localDataSource->getAll('extras/pokemon.json');

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
                throw new DataSourceException("Base species entry not found for {$slug}");
            }

            $container->getEntity()->setBaseSpecies($baseSpecies->getEntity())
                ->setIsLegendary($baseSpecies->getEntity()->isLegendary())
                ->setIsMythical($baseSpecies->getEntity()->isMythical());

            $containersById[$container->getEntity()->getId()] = $container;
        }

        $abilities = $this->abilityRepository->findAll();
        $abilitiesBySlug = [];
        foreach ($abilities as $ability) {
            $abilitiesBySlug[$ability->getSlug()] = $ability;
        }

        // add data
        foreach ($containersById as $id => $container) {
            $baseDataForm = $this->getExtraData($container->getSlug(), 'base_data_form');
            if ($baseDataForm !== null) {
                $baseSpeciesId = $container->getEntity()->getBaseSpecies()->getId();
                $container->getEntity()->setBaseDataForm($containersById[$baseSpeciesId]->getEntity());
                continue;
            }
            $this->normalizeData($container, $abilitiesBySlug);
        }

        ksort($containersById);

        yield from $containersById;
    }

    private function getExtraData(string $slug, string $path, $default = null)
    {
        $poke = $this->extraData[$slug] ?? null;
        if ($poke === null) {
            throw new DataSourceException("Extra data not found for {$slug}");
        }
        if (!Arr::exists($poke, $path)) {
            throw new DataSourceException("Extra data field not found: {$slug}.{$path}");
        }

        return Arr::get($poke, $path, $default);
    }

    private function normalizeAsContainer(array $data): PokemonContainer
    {
        $container = new PokemonContainer($data);
        $entity = $container->getEntity();

        $dexNum = (int)$data['num'];
        $slug = $data['_slug'];
        $formSlug = $data['_formSlug'];
        $baseSpeciesSlug = $data['_baseSpeciesSlug'];

        if ($baseSpeciesSlug === null) {
            $id = $dexNum;
        } else {
            ++$this->maxFormId;
            $id = $this->maxFormId;
        }

        $isMega = Str::contains($formSlug, 'mega');
        $isPrimal = Str::contains($formSlug, 'primal');
        $isTotem = Str::contains($formSlug, 'totem');
        $isGmax = Str::contains($formSlug, 'gmax');
        $isRegional = Str::contains($formSlug, RegionEnum::ALL) && !in_array($formSlug, ['pikachu-hoenn']);

        $entity
            ->setId($id)
            ->setDexNum($dexNum)
            ->setGen($this->getGeneration($data))
            ->setSlug($slug)
            ->setName($data['name'])
            ->setFormSlug($formSlug)
            ->setFormName($data['_formName'])
            ->setBaseSpecies(null)
            ->setImgHome($this->getImgHomePath($dexNum, $slug, $formSlug))
            ->setImgSprite($this->getImgSpritePath($dexNum, $slug, $formSlug))
            ->setShowdownSlug($data['_alias'])
            ->setVeekunSlug(null)
            ->setVeekunFormId(null)
            ->setSortingOrder($this->getSortingOrder($slug, $baseSpeciesSlug ?: $slug))
            ->setIsLegendary($this->getExtraData($slug, 'is_legendary'))
            ->setIsMythical($this->getExtraData($slug, 'is_mythical'))
            ->setIsCosmetic($this->getExtraData($slug, 'is_cosmetic'))
            ->setIsFemale($formSlug === 'f')
            ->setIsFusion($this->getExtraData($slug, 'is_fusion'))
            ->setIsMega($isMega)
            ->setIsPrimal($isPrimal)
            ->setIsRegional($isRegional)
            ->setIsTotem($isTotem)
            ->setIsGmax($isGmax)
            ->setCanDynamax($this->getExtraData($slug, 'can_dynamax'));

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
            ->setHeight((int)($dataSrc->getFloat('heightm', -0.01) * 100))
            ->setWeight((int)($dataSrc->getFloat('weightkg', -0.01) * 100))
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

        $poke = $this->fixBaseForm($poke);

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
                throw new DataSourceException("base-species-mapping entry not found for {$slug}");
            }
            $entry['_baseSpeciesSlug'] = $baseSpeciesSlug;

            $extraForms[$k] = $entry;
        }

        return $extraForms;
    }

    private function fixBaseForm(array $poke): array
    {
        $showdownKey = $poke['_alias'];

        if ($showdownKey === 'alcremie') { // add missing default alcremie topping
            $poke['baseForme'] = 'Vanilla-Cream-Strawberry';

            return $poke;
        }

        if ($showdownKey === 'vivillon') { // vivillon-icy-snow is base form
            $poke['baseForme'] = 'Icy Snow';
            $icyIndex = array_search('Vivillon-Icy Snow', $poke['cosmeticFormes'], true);
            $poke['cosmeticFormes'][$icyIndex] = 'Vivillon-Meadow';

            return $poke;
        }

        if ($showdownKey === 'xerneas') { // xerneas-neutral is base form
            $poke['baseForme'] = 'Neutral';

            return $poke;
        }

        if ($showdownKey === 'xerneasneutral') {
            $poke['name'] = 'Xerneas-Active';
            $poke['baseSpecies'] = 'Xerneas';
            $poke['forme'] = 'Active';

            return $poke;
        }

        return $poke;
    }

    private function expandFemaleCosmeticForms(array $poke): array
    {
        $extraForms = [];

        // add female cosmetic variant if isn't already in the dataset
        if (
            array_key_exists($poke['_slug'] . '-f', $this->extraData)
            && $this->getExtraData($poke['_slug'], 'has_gender_diffs')
            && $this->getExtraData($poke['_slug'] . '-f', 'is_cosmetic')
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
        $showdownKey = $poke['_alias'];
        $extraForms = [];
        $subCosmeticForms = [''];

        if ($showdownKey === 'alcremie') { // add Alcremie toppings as individual forms
            $subCosmeticForms = [
                '-Strawberry',
                '-Berry',
                '-Love',
                '-Star',
                '-Clover',
                '-Flower',
                '-Ribbon',
            ];
            array_unshift($poke['cosmeticFormes'], 'Alcremie-Vanilla-Cream');
        }

        $cosmeticForms = $poke['cosmeticFormes'] ?? [];

        foreach ($cosmeticForms as $cosmeticFormeFullName) {
            foreach ($subCosmeticForms as $subCosmeticForme) {
                $subCosmeticFormeFullName = $cosmeticFormeFullName . $subCosmeticForme;

                if (strtolower($subCosmeticFormeFullName) === 'alcremie-vanilla-cream-strawberry') {
                    // skip alcremie base forme
                    continue;
                }
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

    private function getSortingOrder(string $slug, string $baseSpeciesSlug): int
    {
        $speciesForms = $this->localDataSource->getValue($baseSpeciesSlug, 'extras/pokemon-forms-sorting_order.json');
        if ($speciesForms === null) {
            throw new DataSourceFileIoException("No FormsOrder entry for species '{$baseSpeciesSlug}' found.");
        }
        $speciesForms = array_flip($speciesForms);
        $order = $speciesForms[$slug] ?? null;
        if ($order === null) {
            throw new DataSourceFileIoException("No FormsOrder entry for form '{$baseSpeciesSlug}.{$slug}' found.");
        }

        return $order;
    }

    private function getImgHomePath(int $num, string $slug, ?string $formSlug): string
    {
        $defaultSprite = $this->rangeFolderCalculator->calculate($num, 4, 100) .
            DIRECTORY_SEPARATOR .
            StrFormat::zeroPadLeft($num, 4) . (empty($formSlug) ? '' : '-' . $formSlug);

        $override = $this->getExtraData($slug, 'img_home');

        return $override ?: $defaultSprite;
    }

    private function getImgSpritePath(int $num, string $slug, ?string $formSlug): string
    {
        $override = $this->getExtraData($slug, 'img_sprite');

        return $override ?: $slug;
    }

    private function getGeneration(array $poke): int
    {
        $formName = strtolower($poke['_formName'] ?: '');

        if (Str::contains($formName, ['mega', 'primal'])) {
            return 6;
        }

        if (Str::contains($formName, ['starter', 'power-construct', 'alola', 'totem'])) {
            return 7;
        }

        if (Str::contains($formName, ['gmax', 'galar'])) {
            return 8;
        }

        $gen = $poke['gen'] ?? 0;

        return ($gen > 0) ? $gen : $this->dexNumberGenMapper->getGenerationByDexNum((int)$poke['num']);
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

        return ['male' => (int)$genderRatio['male'] * 100, 'female' => (int)$genderRatio['female'] * 100];
    }
}
