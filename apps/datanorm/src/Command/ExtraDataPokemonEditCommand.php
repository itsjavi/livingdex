<?php

declare(strict_types=1);

namespace App\Command;

use App\DataSources\Data\VeekunDataMapping;
use App\DataSources\DataSourceFileIo;
use App\Support\Serialization\Encoder\JsonEncoder;
use JsonPath\JsonObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExtraDataPokemonEditCommand extends Command
{
    private const FILENAME = 'pokemon.json';

    private const ACTION_QUERY = 'q';
    private const ACTION_DELETE = 'd';
    private const ACTION_SET = 's';
    private const ACTION_BATCH_SET = 'b';

    private const ACTIONS = [
        'q/query'                   => self::ACTION_QUERY,
        'd/delete'                  => self::ACTION_DELETE,
        's/set'                     => self::ACTION_SET,
        'b/batch-set (interactive)' => self::ACTION_BATCH_SET,
    ];

    protected static $defaultName = 'app:extra-data-edit:pokemon';

    private DataSourceFileIo $dataSourceFileReader;

    public function __construct(
        DataSourceFileIo $dataSourceFileReader

    ) {
        parent::__construct();

        $this->dataSourceFileReader = $dataSourceFileReader;
    }

    protected function configure()
    {
        $this
            ->setDescription(
                'Command to maintain the DataSource/Data/extras/pokemon.json file'
            )
            ->addArgument(
                'action',
                InputArgument::REQUIRED,
                'Action to perform: ' . implode(',', array_keys(self::ACTIONS))
            )
            ->addArgument(
                'xpath',
                InputArgument::OPTIONAL,
                'JSON XPath to read or write. Not required for the batch set.'
            )
            ->addArgument(
                'value',
                InputArgument::OPTIONAL,
                'Value to set in the "set" action. For the delete action, it\'s the field to remove.' . PHP_EOL .
                'Type is automatically detected. It accepts: string, null, false, true, numeric, json struct, etc.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $actionRaw = $input->getArgument('action');
        $action = strtolower($actionRaw[0]);
        $xpath = '$' . $input->getArgument('xpath');
        $valueRaw = $input->getArgument('value');
        $value = $this->normalizeValue($valueRaw);

        if (!in_array($action, self::ACTIONS)) {
            $io->error("Invalid action: {$actionRaw}");

            return 1;
        }

        $data = $this->dataSourceFileReader->getAll(self::FILENAME);

        if ($action === self::ACTION_QUERY) {
            return $this->execQueryAction($data, $xpath, $io);
        }

        if ($action === self::ACTION_SET) {
            return $this->execSetAction($data, $xpath, $value, $io);
        }

        if ($action === self::ACTION_DELETE) {
            return $this->execDeleteAction($data, $xpath, (string)$valueRaw, $io);
        }

        if ($action === self::ACTION_BATCH_SET) {
            return $this->execBatchSetAction($data, $io);
        }

        return 0;
    }

    private function execQueryAction(array $data, string $xpath, SymfonyStyle $io): int
    {
        $dataApi = new JsonObject($data);
        $result = $dataApi->get($xpath);
        $io->writeln(JsonEncoder::encodePrettyCompact($result));

        return 0;
    }

    private function execSetAction(array $data, string $xpath, $value, SymfonyStyle $io): int
    {
        $dataApi = new JsonObject($data);
        $result = $dataApi->set($xpath, $value);
        $this->dataSourceFileReader->writeFile(
            self::FILENAME,
            JsonEncoder::encodePrettyCompact($result->getValue())
        );

        $io->writeln("Data has been set.");

        return 0;
    }

    private function execDeleteAction(array $data, string $xpath, string $field, SymfonyStyle $io): int
    {
        $dataApi = new JsonObject($data);
        $result = $dataApi->remove($xpath, $field);
        $this->dataSourceFileReader->writeFile(
            self::FILENAME,
            JsonEncoder::encodePrettyCompact($result->getValue())
        );

        $io->writeln("Data has been removed.");

        return 0;
    }

    private function execBatchSetAction(array $data, SymfonyStyle $io): int
    {
//        $io->askQuestion(
//            new Question(
//                'First you will be asked the pokemon to start with and then' . PHP_EOL .
//                'the field to edit in all of them, starting from the selected Pokemon.' . PHP_EOL . PHP_EOL .
//                'Press ENTER to continue'
//            )
//        );
//
        $pokeAnswer = $io->askQuestion(
            $this->createAutocompleteQuestion(
                'What Pokemon do you want to start with?',
                'pokemon slug',
                array_keys($data),
                'meltan'
            )
        );

        $fieldAnswer = $io->askQuestion(
            $this->createAutocompleteQuestion(
                'What field do you want to edit?',
                'property name',
                array_keys(current($data))
            )
        );

        $genNotApplicable = 'n/a';
        $genAnswer = $genNotApplicable;
        $genBasedFields = [
            "catch_rate",
            "base_friendship",
            "shape",
            "growth_rate",
            "yield_base_exp",
            "yield_stats",
            "hatch_cycles",
        ];

        if (in_array($fieldAnswer, $genBasedFields, true)) {
            $genAnswer = $io->askQuestion(
                $this->createAutocompleteQuestion(
                    "Generation of these changes: ",
                    'generation',
                    [$genNotApplicable] + array_map(fn($num) => 'gen-' . $num, range(1, 10)),
                    'gen-8'
                )
            );
        }

        $fieldValueChoices = [];

        if ($fieldAnswer === 'shape') {
            $fieldValueChoices = VeekunDataMapping::SHAPES;
        } elseif ($fieldAnswer === 'growthRate') {
            $fieldValueChoices = VeekunDataMapping::GROWTH_RATES;
        } elseif (preg_match('/^(is|can|has)[A-Z]/', $fieldAnswer)) {
            $fieldValueChoices = ['true', 'false'];
        } elseif ($fieldAnswer === 'yield_stats') {
            $fieldValueChoices = ['true', 'false'];
        }

        $started = false;

        foreach ($data as $slug => $poke) {
            if ($pokeAnswer === $slug) {
                $io->writeln("\n--- Starting from '{$slug}' ---\n");
                $started = true;
            }
            if ($started === false) {
                continue;
            }

            if ($fieldAnswer === 'yield_stats') {
                $value = [];
                foreach (['HP', 'Attack', 'Defense', 'Sp.Attack', 'Sp.Defense', 'Speed'] as $i => $stat) {
                    $question = $this->createAutocompleteQuestion(
                        "{$slug}.{$fieldAnswer}.{$i} ({$stat} stat) (-1=EXIT) = ",
                        $fieldAnswer,
                        range(-1, 3),
                        0
                    );

                    $val = (int)$io->askQuestion($question);
                    if ($val === -1) {
                        $value = null;
                        break;
                    }
                    $value[] = $val;
                }
            } else {
                $question = $this->createAutocompleteQuestion(
                    "{$slug}.{$fieldAnswer} = ",
                    $fieldAnswer,
                    $fieldValueChoices
                );

                $value = $io->askQuestion($question);
            }

            if ($value === null) {
                if ($io->askQuestion(
                        new ChoiceQuestion("do you want to stop here?", ['y', 'n'], 'y')
                    ) === 'y') {
                    break;
                }
                $value = null;
            }

            $normalizedValue = $this->normalizeValue($value);

            $data[$slug][$fieldAnswer] = ($genAnswer === $genNotApplicable) ?
                $normalizedValue : [$genAnswer => $normalizedValue];
        }

        $io->writeln("Done. Saving the JSON file...");
        $this->dataSourceFileReader->writeFile(
            self::FILENAME,
            JsonEncoder::encodePrettyCompact($data)
        );
        $io->writeln("Data has been set. Check the git diff to verify your changes:");
        $io->writeln(
            str_replace('/usr/src/app/', 'git diff ./', $this->dataSourceFileReader->getFilePath(self::FILENAME))
        );

        return 0;
    }

    private function createAutocompleteQuestion(
        string $questionText,
        string $fieldName,
        ?array $choices,
        $default = null
    ): Question {
        $question = new Question($questionText, $default);
        if (empty($choices)) {
            return $question;
        }

        $question->setAutocompleterValues($choices);
        $question->setValidator(
            function ($answer) use ($choices, $fieldName) {
                if ($answer === null || $answer === '' || $answer === PHP_EOL) {
                    return null;
                }

                if (!in_array($answer, $choices, false)) {
                    throw new \RuntimeException("'{$answer}' is an invalid {$fieldName} value. Introduce a valid one.");
                }

                return $answer;
            }
        );

        return $question;
    }

    /**
     * @param string|mixed $val
     * @return array|bool|float|mixed|null
     */
    private function normalizeValue($val)
    {
        if (is_array($val) || !is_scalar($val)) {
            return $val;
        }
        if (strtoupper($val) === 'FALSE') {
            return false;
        }
        if (strtoupper($val) === 'TRUE') {
            return true;
        }
        if (strtoupper($val) === 'NULL') {
            return null;
        }
        if (preg_match('/^[{\[].*[\}\]]$/', $val)) {
            return JsonEncoder::decode($val);
        }
        if (is_numeric($val)) {
            return (strpos($val, '.') !== false) ? (float)$val : (int)$val;
        }

        return $val;
    }
}
