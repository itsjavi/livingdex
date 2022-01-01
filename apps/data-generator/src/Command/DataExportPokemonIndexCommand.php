<?php

declare(strict_types=1);

namespace App\Command;

use App\DataSources\Generation;
use App\Entity\LivingDex\Pokemon;
use App\Support\Serialization\Encoder\JsonEncoder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DataExportPokemonIndexCommand extends Command
{
    protected static $defaultName = 'app:data:export-pokemon-index';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setDescription('Exports the list of all Pokemon and forms, with some basic info.')
            ->addArgument('output-dir', InputArgument::REQUIRED, 'Output directory');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $outputPath = $input->getArgument("output-dir");

        /** @var Pokemon[] $pokemonCollection */
        $pokemonCollection = $this->entityManager
            ->getRepository(Pokemon::class)
            ->createQueryBuilder('p')
            ->orderBy('p.dexNum, p.sortingOrder')
            ->getQuery()
            ->getResult();

        $io->writeln("Exporting Pokemon list...");
        $pokemonIndex = $this->createPokemonIndex($pokemonCollection);
        $this->writeData($pokemonIndex, "{$outputPath}/pokemon-index.json");

        $io->success('Index Export finished.');

        return 0;
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

        if ($pokemon->getBaseSpecies() !== null) {
            // print_r([$pokemon->getSlug() => $dataByGen]);
        }

        return $dataByGen;
    }

    /**
     * @param Pokemon[] $pokemonCollection
     * @return array
     */
    private function createPokemonIndex(iterable $pokemonCollection): array
    {
        $pokemonIndex = [];

        foreach ($pokemonCollection as $poke) {
            $forms = $poke->getChildren()->map(fn(Pokemon $form): string => $form->getSlug())->toArray();
            $data = $this->getDataByGen($poke)[Generation::MAX_GEN];
            $imageFile = $poke->getSlug();
            $pokemonIndex[] = [
                'id' => $poke->getId(),
                'num' => $poke->getDexNum(),
                'slug' => $poke->getSlug(),
                'name' => $poke->getName(),
                'gen' => $poke->getGen(),
                'type1' => $data['type1'] ?? null,
                'type2' => $data['type2'] ?? null,
                'color' => $data['color'] ?? null,
                'forms' => $forms,
                'baseForm' => $poke->getBaseSpecies()?->getSlug(),
                'tags' => $this->getTags($poke),
                'images' => [
                    'regular' => $imageFile,
                    'icon' => $imageFile
                ]
            ];
        }

        return $pokemonIndex;
    }

    private function getTags(Pokemon $pokemon): array
    {
        $tags = [];
        if ($pokemon->isCosmetic()) {
            $tags[] = 'cosmetic';
        }
        if ($pokemon->isAbilityForm()) {
            $tags[] = 'special-ability';
        }
        if ($pokemon->isBattleOnly()) {
            $tags[] = 'battle-only';
        }
        if ($pokemon->isReversible()) {
            $tags[] = 'reversible';
        }
        if ($pokemon->isFemale()) {
            $tags[] = 'female';
        }
        if ($pokemon->isRegional()) {
            $tags[] = 'regional';
        }
        if ($pokemon->isGmax()) {
            $tags[] = 'gigantamax';
        }
        if ($pokemon->isMega()) {
            $tags[] = 'mega';
        }
        if ($pokemon->isPrimal()) {
            $tags[] = 'primal';
        }
        if ($pokemon->isTotem()) {
            $tags[] = 'totem';
        }
        if ($pokemon->isFusion()) {
            $tags[] = 'fusion';
        }
        if ($pokemon->isLegendary()) {
            $tags[] = 'legendary';
        }
        if ($pokemon->isMythical()) {
            $tags[] = 'mythical';
        }
        if (!$pokemon->isHomeStorable() && !$pokemon->isHomeRegistrable()) {
            $tags[] = 'legacy';
        }

        return $tags;
    }

    private function writeData(array $data, string $file): bool
    {
        if (file_exists($file)) {
            // error_log("IO Warning: Output file already exists: {$file}");
        }

        $json = empty($data) ? ('[]' . PHP_EOL) : JsonEncoder::encodePrettyCompact($data, 4);

        return file_put_contents($file, $json) !== false;
    }
}
