<?php

declare(strict_types=1);

namespace App\Command;

use App\Support\Serialization\Doctrine\ResultStatementSerializer;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DataExportCommand extends Command
{
    protected static $defaultName = 'app:data:export';

    private Connection $defaultConnection;
    private Connection $veekunConnection;
    private ResultStatementSerializer $resultEncoder;

    public function __construct(
        Connection $defaultConnection,
        Connection $veekunConnection,
        ResultStatementSerializer $resultEncoder
    ) {
        parent::__construct();

        $this->defaultConnection = $defaultConnection;
        $this->veekunConnection = $veekunConnection;
        $this->resultEncoder = $resultEncoder;
    }

    protected function configure()
    {
        $this
            ->setDescription('Exports a SQL result to the specified format')
            ->addArgument('sql', InputArgument::REQUIRED, 'Select SQL query to execute')
            ->addOption('format', 'f', InputOption::VALUE_REQUIRED, 'Export format', 'csv')
            ->addOption(
                'connection',
                'c',
                InputOption::VALUE_REQUIRED,
                'Doctrine SQL connection name to use',
                'default'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $sql = $input->getArgument('sql');
        $format = strtolower($input->getOption('format'));
        $connectionName = $input->getOption('connection');

        if (!in_array($format, ResultStatementSerializer::FORMATS, true)) {
            $io->error("Wrong format: Only csv, json and php are supported.");

            return 1;
        }

        /** @var Connection $connection */
        $connection = [
                'default' => $this->defaultConnection,
                'veekun' => $this->veekunConnection,
            ][$connectionName] ?? null;

        if ($connection === null) {
            $io->error("Wrong connection name: Only default and veekun are supported.");

            return 2;
        }

        $stmt = $connection->executeQuery($sql);
        $lines = $this->resultEncoder->encode($stmt, $format);
        $output->writeln($lines);

        return 0;
    }
}
