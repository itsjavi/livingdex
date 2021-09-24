<?php

declare(strict_types=1);

namespace App\Support\Serialization\Encoder;

use Generator;
use Laminas\Code\Generator\ValueGenerator;

final class PhpEncoder
{
    public static function encode($data): string
    {
        $generator = new ValueGenerator(
            $data,
            is_array($data) ? ValueGenerator::TYPE_ARRAY_SHORT : ValueGenerator::TYPE_AUTO
        );

        $generator->setIndentation('    ');

        return $generator->generate();
    }

    public static function encodeAssoc(array $row): string
    {
        $exported = [];
        foreach ($row as $value) {
            if (is_numeric($value)) {
                if (strpos($value, '.') !== false) {
                    $value = (float)$value;
                } else {
                    $value = (int)$value;
                }
            }
            $exported[] = self::encode($value);
        }

        if (count($exported) === 1) {
            return '    ' . $exported[0] . ',';
        }

        return '    [' . implode(', ', $exported) . '],';
    }

    public static function encodeAssocCollection(iterable $collection): Generator
    {
        $columns = null;
        yield "<?php\n\nreturn [";
        foreach ($collection as $row) {
            if ($columns === null) {
                $columns = array_keys($row);
                if (count($columns) > 1) {
                    yield self::encodeAssoc($columns);
                }
            }
            yield self::encodeAssoc($row);
        }
        yield '];';
    }
}
