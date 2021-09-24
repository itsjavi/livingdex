<?php

declare(strict_types=1);

namespace App\Command;

use App\Support\Serialization\Encoder\CsvEncoder;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DataImportCommand extends Command
{
    private const TABLES = [
        'game_group',
        'game',
        'ability',
        'pokemon',
        'pokemon_data',
    ];

    protected static $defaultName = 'app:data:import';

    private Connection $defaultConnection;
    private string $csvDataDir;

    public function __construct(
        Connection $defaultConnection,
        string $csvDataDir
    ) {
        parent::__construct();

        $this->defaultConnection = $defaultConnection;
        $this->csvDataDir = $csvDataDir;
    }

    protected function configure()
    {
        $this
            ->setDescription(
                'Imports the CSV data files into the database.' .
                'This command is only meant for testing purposes, to verify the integrity of the CSV files.' .
                'To import the right state of the data, use "doctrine:fixtures:load -n" instead' .
                ", since the CSV files might be out of sync with the source data."
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach (self::TABLES as $table) {
            $file = $this->csvDataDir . "/{$table}.csv";

            if (!file_exists($file) || !is_file($file) || !is_readable($file)) {
                $io->warning("Table CSV for {$table} does not exist in {$file}. Skipped.");
                continue;
            }

            $columns = null;
            $colsList = null;
            $varsList = null;
            $queryTemplate = null;

            $csvIterator = CsvEncoder::decodeFile($file);

            foreach ($csvIterator as $csvRow) {
                if (!is_array($columns)) {
                    $columns = $csvRow;
                    $colsList = implode(', ', $columns);
                    $varsList = array_map(fn($column) => ":{$column}", $columns);
                    $queryTemplate = sprintf(
                        "INSERT INTO {$table} (%s) VALUES (%s)",
                        $colsList,
                        implode(', ', $varsList)
                    );
                    continue;
                }

                $queryParams = array_combine($varsList, $csvRow);

                foreach ($queryParams as $k => $param) {
                    if ($param === '') {
                        $queryParams[$k] = null;
                    }
                }

                $this->defaultConnection->executeQuery($queryTemplate, $queryParams);
            }
            $io->success("Table {$table} imported successfully from {$file}");
        }

        return 0;
    }
}
