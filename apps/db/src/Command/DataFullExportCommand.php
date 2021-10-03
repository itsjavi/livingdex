<?php

declare(strict_types=1);

namespace App\Command;

use App\DataSources\Generation;
use App\Entity\LivingDex\Ability;
use App\Entity\LivingDex\Game;
use App\Entity\LivingDex\GameGroup;
use App\Entity\LivingDex\Pokemon;
use App\Support\Serialization\Encoder\JsonEncoder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DataFullExportCommand extends Command
{
    protected static $defaultName = 'app:data:export-full';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setDescription('Exports all data required for the LivingDex React UI app.')
            ->addArgument('output-dir', InputArgument::REQUIRED, 'Output directory');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $outputPath = $input->getArgument("output-dir");

        $io->writeln("Generating Game entries...");
        $gameEntries = $this->createGameEntries();
        $this->writeData(array_values($gameEntries), "{$outputPath}/games.json");

        /** @var Pokemon[] $pokemonCollection */
        $pokemonCollection = $this->entityManager
            ->getRepository(Pokemon::class)
            ->createQueryBuilder('p')
            ->orderBy('p.dexNum, p.sortingOrder')
            ->getQuery()
            ->getResult();

        $io->writeln("Generating Abilities index...");
        $abilityEntries = $this->createAbilityEntries();
        foreach ($abilityEntries as $gen => $entries) {
            $genOutputPath = "{$outputPath}/gen/{$gen}";
            $this->createDir($genOutputPath);
            $this->writeData(array_values($entries), "{$genOutputPath}/abilities.json");
        }

        $io->writeln("Generating Pokemon species index...");
        $pokemonIndex = $this->createPokemonIndex($pokemonCollection);
        foreach ($pokemonIndex as $gen => $pokemonList) {
            $genOutputPath = "{$outputPath}/gen/{$gen}";
            $this->createDir($genOutputPath);
            $this->writeData(array_values($pokemonList), "{$genOutputPath}/pokemon.json");
        }

        $io->writeln("Generating Pokemon entries...");
        $pokemonIndexFull = $this->createPokemonIndex($pokemonCollection, true);
        foreach ($pokemonIndexFull as $gen => $pokemonListFull) {
            $genOutputPath = "{$outputPath}/gen/{$gen}";
            $this->createDir($genOutputPath);
            $this->writeData(array_values($pokemonListFull), "{$genOutputPath}/pokemon-forms.json");
        }

        $pokemonEntriesIndex = $this->createPokemonEntries($pokemonIndexFull, $pokemonCollection);
        foreach ($pokemonEntriesIndex as $gen => $pokemonEntries) {
            foreach ($pokemonEntries as $poke) {
                $genOutputPath = "{$outputPath}/gen/{$gen}/pokemon";
                $this->createDir($genOutputPath);
                $this->writeData($poke, "{$genOutputPath}/{$poke['slug']}.json");
            }
        }

        $io->success('Full Export finished.');

        return 0;
    }

    private function createAbilityEntries(): array
    {
        $index = [];

        /** @var Ability[] $entities */
        $entities = $this->entityManager
            ->getRepository(Ability::class)
            ->createQueryBuilder('t')
            ->orderBy('t.id')
            ->getQuery()
            ->getResult();


        foreach ($entities as $entity) {
            for ($gen = $entity->getGen(); $gen <= Generation::MAX_GEN; $gen++) {
                $index[$gen][] = [
                    'id' => $entity->getId(),
                    'slug' => $entity->getSlug(),
                    'name' => $entity->getName(),
                    'gen' => $entity->getGen(),
                    'rating' => $entity->getRating(),
                    'showdownName' => $entity->getShowdownName(),
                    'veekunName' => $entity->getVeekunName(),
                ];
            }
        }

        foreach (range(1, Generation::MAX_GEN) as $gen) {
            if (!isset($index[$gen])) {
                $index[$gen] = [];
            }
        }

        return $index;
    }

    private function createGameEntries(): array
    {
        /** @var GameGroup[] $gameGroups */
        $gameGroups = $this->entityManager
            ->getRepository(GameGroup::class)
            ->createQueryBuilder('g')
            ->orderBy('g.sortingOrder')
            ->getQuery()
            ->getResult();

        $gamesIndex = [];

        foreach ($gameGroups as $gameGroup) {
            $gamesIndex[] = [
                'id' => $gameGroup->getId(),
                'slug' => $gameGroup->getSlug(),
                'name' => $gameGroup->getName(),
                'gen' => $gameGroup->getGen(),
                'region' => $gameGroup->getRegion(),
                'date' => $gameGroup->getReleaseDate()->format('Y-m-d'),
                'order' => $gameGroup->getSortingOrder(),
                'games' => array_map(
                    static fn(Game $game) => [
                        'id' => $game->getId(),
                        'slug' => $game->getSlug(),
                        'name' => $game->getName(),
                        'gen' => $game->getGen(),
                        'order' => $game->getSortingOrder(),
                    ],
                    $gameGroup->getGames()->toArray()
                ),
            ];
        }

        return $gamesIndex;
    }

    /**
     * @param array $pokemonIndex
     * @param Pokemon[] $pokemonCollection
     * @return array
     */
    private function createPokemonEntries(array $pokemonIndex, iterable $pokemonCollection): array
    {
        $pokemonEntries = $pokemonIndex;

        foreach ($pokemonCollection as $poke) {
            $datum = $this->getDataByGen($poke);
            $slug = $poke->getSlug();

            for ($gen = $poke->getGen(); $gen <= Generation::MAX_GEN; $gen++) {
                $pokeByGen = $pokemonIndex[$gen][$slug];

                unset(
                    $pokeByGen['baseSpecies'],
                    $pokeByGen['imgSprite'],
                    $pokeByGen['imgHome'],
                    $pokeByGen['isCosmetic'],
                    $pokeByGen['isHomeStorable'],
                    $pokeByGen['formOrder']
                );

                $pokemonEntries[$gen][$slug] = $pokeByGen
                    + [
                        'formName' => $poke->getFormName(),
                        'formSlug' => $poke->getFormSlug(),
                        'formOrder' => $poke->getSortingOrder(),
                        'baseSpecies' => $poke->getBaseSpecies() ? $poke->getBaseSpecies()->getSlug() : null,
                        'baseDataForm' => $poke->getBaseDataForm() ? $poke->getBaseDataForm()->getSlug() : null,
                        'imgSprite' => $poke->getImgSprite(),
                        'imgHome' => $poke->getImgHome(),
                    ]
                    + $datum[$gen]
                    + [
                        'isFemale' => $poke->isFemale(),
                        //'hasFemale' => $hasFemale,
                        'isCosmetic' => $poke->isCosmetic(),
                        'isLegendary' => $poke->isLegendary(),
                        'isMythical' => $poke->isMythical(),
                        'isFusion' => $poke->isFusion(),
                        'isMega' => $poke->isMega(),
                        //'hasMega' => $hasMega,
                        'isPrimal' => $poke->isPrimal(),
                        'isGmax' => $poke->isGmax(),
                        //'hasGmax' => $hasGmax,
                        'canDynamax' => $poke->canDynamax(),
                        'isTotem' => $poke->isTotem(),
                        'isRegional' => $poke->isRegional(),
                        'isHomeStorable' => $poke->isHomeStorable(),
                        //'games' => $games,
                        'showdownSlug' => $poke->getShowdownSlug(),
                        'veekunSlug' => $poke->getVeekunSlug(),
                        'veekunFormId' => $poke->getVeekunFormId(),
                    ];
            }
        }

        return $pokemonEntries;
    }

    /**
     * @param Pokemon $pokemon
     * @return array[]
     */
    private function getDataByGen(Pokemon $pokemon): array
    {
        $datum = $pokemon->getDatum();

        $dataByGen = [];

        foreach ($datum as $data) {
            $dataByGen[$data->getGen()] = $data->toArray();
        }

        ksort($dataByGen);

        foreach (range(1, Generation::MAX_GEN) as $gen) {
            if (empty($dataByGen)) {
                $dataByGen[$gen] = [];
                continue;
            }

            // take data from previous gens
            if (!isset($dataByGen[$gen])) {
                for ($prevGen = ($gen - 1); $prevGen > 0; $prevGen--) {
                    if (isset($dataByGen[$prevGen])) {
                        $dataByGen[$gen] = $dataByGen[$prevGen];
                    }
                }
            }

            // fallback next gens
            if (!isset($dataByGen[$gen])) {
                for ($nextGen = Generation::MAX_GEN; $nextGen > $gen; $nextGen--) {
                    if (isset($dataByGen[$nextGen])) {
                        $dataByGen[$gen] = $dataByGen[$nextGen];
                    }
                }
            }

            // fallback to last gen
            if (!isset($dataByGen[$gen])) {
                $dataByGen[$gen] = end($dataByGen);
            }
        }

        return $dataByGen;
    }

    /**
     * @param Pokemon[] $pokemonCollection
     * @param bool $withForms
     * @return array
     */
    private function createPokemonIndex(iterable $pokemonCollection, bool $withForms = false): array
    {
        $pokemonIndex = [];

        foreach ($pokemonCollection as $poke) {
            if ($withForms === false && ($poke->getBaseSpecies() !== null)) {
                continue;
            }

            $forms = $poke->getChildren();

            $pokemonIndexEntry = [
                'id' => $poke->getId(),
                'num' => $poke->getDexNum(),
                'slug' => $poke->getSlug(),
                'name' => $poke->getName(),
                'gen' => $poke->getGen(),
                'forms' => [],
            ];

            if ($withForms) {
                $pokemonIndexEntry['baseSpecies'] = $poke->getBaseSpecies() ? $poke->getBaseSpecies()->getSlug() : null;
                $pokemonIndexEntry['imgSprite'] = $poke->getImgSprite();
                $pokemonIndexEntry['imgHome'] = $poke->getImgHome();
                $pokemonIndexEntry['formOrder'] = $poke->getSortingOrder();
                $pokemonIndexEntry['isCosmetic'] = $poke->isCosmetic();
                $pokemonIndexEntry['isHomeStorable'] = $poke->isHomeStorable();
            }

            for ($gen = $poke->getGen(); $gen <= Generation::MAX_GEN; $gen++) {
                $pokemonIndexGenEntry = $pokemonIndexEntry;
                foreach ($forms as $form) {
                    if ($form->getGen() > $gen) {
                        continue;
                    }
                    $pokemonIndexGenEntry['forms'][] = $form->getSlug();
                }
                $pokemonIndex[$gen][$pokemonIndexGenEntry['slug']] = $pokemonIndexGenEntry;
            }
        }

        return $pokemonIndex;
    }

    private function createDir(string $dir): void
    {
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0755, true) && !is_dir($dir)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
            }
        }
    }

    private function writeData(array $data, string $file): bool
    {
        if (file_exists($file)) {
            error_log("IO Warning: Output file already exists: {$file}");
        }

        $json = empty($data) ? ('[]' . PHP_EOL) : JsonEncoder::encodePrettyCompact($data, 4);

        return file_put_contents($file, $json) !== false;
    }
}
