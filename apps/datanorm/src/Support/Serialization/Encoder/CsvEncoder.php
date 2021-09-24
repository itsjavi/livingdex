<?php

declare(strict_types=1);

namespace App\Support\Serialization\Encoder;

use App\Support\FileNotFoundException;
use Generator;

final class CsvEncoder
{
    public static function decodeFile(string $file): \Generator
    {
        if (!file_exists($file) || !is_readable($file) || !is_file($file)) {
            throw new FileNotFoundException($file);
        }

        $fileStream = fopen($file, 'rb');

        while (!feof($fileStream)) {
            $row = fgetcsv($fileStream);
            if (!is_array($row)) {
                break;
            }
            yield $row;
        }
        fclose($fileStream);
    }

    public static function decodeFileAssoc(string $file): \Generator
    {
        if (!file_exists($file) || !is_readable($file) || !is_file($file)) {
            throw new FileNotFoundException($file);
        }

        $fileStream = fopen($file, 'rb');
        $columns = null;

        while (!feof($fileStream)) {
            $row = fgetcsv($fileStream);
            if (!is_array($row)) {
                break;
            }

            if ($columns === null) {
                $columns = $row;
                continue;
            }

            yield array_combine($columns, $row);
        }
        fclose($fileStream);
    }

    public static function encodeAssocCollection(iterable $collection): Generator
    {
        $buffer = fopen('php://memory', 'wb');
        $columns = null;
        foreach ($collection as $row) {
            if ($columns === null) {
                $columns = array_keys($row);
                yield self::encodeArray($buffer, $columns);
            }
            yield self::encodeArray($buffer, array_values($row));
        }
        fclose($buffer);
    }

    private static function encodeArray($buffer, array $row): string
    {
        fputcsv($buffer, array_values($row));
        rewind($buffer);
        $encoded = trim(fgets($buffer));
        rewind($buffer);

        return $encoded;
    }
}
