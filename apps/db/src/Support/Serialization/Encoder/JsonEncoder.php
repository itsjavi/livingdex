<?php

declare(strict_types=1);

namespace App\Support\Serialization\Encoder;

use App\Support\FileNotFoundException;
use Generator;
use JsonException;

final class JsonEncoder
{
    public const DEFAULT_INDENT = 4;

    public static function decode($json, int $flags = 0, string $rootProperty = null): array
    {
        $data = json_decode((string)$json, true, 512, $flags | JSON_THROW_ON_ERROR);

        if (!is_array($data)) {
            throw new JsonException('Decoded JSON is not an array.');
        }

        if ($rootProperty !== null && !array_key_exists($rootProperty, $data)) {
            throw new JsonException("JSON doesn't contain expected root property: {$rootProperty}.");
        }

        return $rootProperty === null ? $data : $data[$rootProperty];
    }

    public static function encodePrettyCompact($value, $maxIndent = 2, bool $newLine = true): string
    {
        return self::encode(
                $value,
                JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT,
                2,
                $maxIndent
            ) . ($newLine ? PHP_EOL : '');
    }

    public static function encode(
        $value,
        int $flags = JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT,
        int $indent = self::DEFAULT_INDENT,
        int $indentMaxDepth = 10,
        string $indentMaxReplacement = ' '
    ): string {
        $prettify = ($flags & JSON_PRETTY_PRINT) === JSON_PRETTY_PRINT;
        $json = json_encode($value, $flags | JSON_THROW_ON_ERROR);

        if (!$prettify || ($indentMaxDepth === 0)) {
            return $json;
        }

        $indentedSpace = self::DEFAULT_INDENT * ($indentMaxDepth + 1);
        $leadingIndentedSpace = self::DEFAULT_INDENT * $indentMaxDepth;

        $json = preg_replace("/\\n^\\s{{$indentedSpace},}/m", $indentMaxReplacement, $json);
        $json = preg_replace("/\\n^\\s{{$leadingIndentedSpace},}([]}])(,?)\$/m", '$1$2', $json);

        $originalIndent = self::DEFAULT_INDENT;
        $json = preg_replace(
            "/^\\s{{$originalIndent}}|\\G\\s{{$originalIndent}}/m",
            str_repeat(' ', $indent),
            $json
        );

        return $json;
    }

    public static function encodeAssocCollection(iterable $collection, bool $singleFieldAsList = true): Generator
    {
        yield '[';
        $i = 0;
        foreach ($collection as $row) {
            if ($singleFieldAsList && (count($row) === 1)) {
                yield ($i === 0 ? '  ' : '  ,') . self::encode(array_shift($row));
            } else {
                yield ($i === 0 ? '  ' : '  ,') . self::encode($row);
            }
            $i++;
        }
        yield ']';
    }

    public static function decodeFile(
        string $file,
        string $rootProperty = null,
        int $flags = 0
    ): array {
        if (!file_exists($file) || !is_readable($file) || !is_file($file)) {
            throw new FileNotFoundException($file);
        }

        $json = file_get_contents($file);

        if (!is_string($json)) {
            throw new JsonException('Failed to read JSON file: ' . $file);
        }

        return self::decode($json, $flags, $rootProperty);
    }
}
