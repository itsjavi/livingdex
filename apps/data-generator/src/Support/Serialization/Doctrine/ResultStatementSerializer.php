<?php

declare(strict_types=1);

namespace App\Support\Serialization\Doctrine;

use App\Support\Serialization\Encoder\CsvEncoder;
use App\Support\Serialization\Encoder\JsonEncoder;
use App\Support\Serialization\Encoder\PhpEncoder;
use Doctrine\DBAL\Result;

class ResultStatementSerializer
{
    public const FORMATS = [
        self::FORMAT_CSV,
        self::FORMAT_PHP,
        self::FORMAT_JSON,
    ];

    public const FORMAT_CSV = 'csv';
    public const FORMAT_PHP = 'php';
    public const FORMAT_JSON = 'json';

    private function toGenerator(Result $stmt): \Generator
    {
        while ($row = $stmt->fetchAssociative()) {
            yield $row;
        }
    }

    public function encode(Result $stmt, $format = self::FORMAT_CSV): \Generator
    {
        $rowGenerator = $this->toGenerator($stmt);

        switch ($format) {
            case self::FORMAT_CSV:
            {
                return CsvEncoder::encodeAssocCollection($rowGenerator);
            }
            case self::FORMAT_JSON:
            {
                return JsonEncoder::encodeAssocCollection($rowGenerator);
            }
            case self::FORMAT_PHP:
            {
                return PhpEncoder::encodeAssocCollection($rowGenerator);
            }
            default:
            {
                throw new ResultStatementSerializationException('Format not supported: ' . $format);
            }
        }
    }
}
