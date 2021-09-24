<?php

declare(strict_types=1);

namespace App\DataSources;

use App\Support\Serialization\Encoder\CsvEncoder;
use App\Support\Serialization\Encoder\JsonEncoder;

class DataSourceFileIo
{
    private static array $cache = [];
    private string $dataSourceDir;

    public function __construct(string $dataSourceDir)
    {
        $this->dataSourceDir = $dataSourceDir;
    }

    public function hasKey(string $key, string $fileName): bool
    {
        $data = $this->getAll($fileName);

        return array_key_exists($key, $data);
    }

    public function hasValue(string $value, string $fileName): bool
    {
        $data = $this->getAll($fileName);

        return in_array($value, $data, true);
    }

    /**
     * @alias hasValue
     * @param string $value
     * @param string $fileName
     * @return bool
     */
    public function contains(string $value, string $fileName): bool
    {
        return $this->hasValue($value, $fileName);
    }

    /**
     * @param string $key
     * @param string $fileName
     * @param mixed  $default
     * @return string|int|float|bool|array
     */
    public function getValue(string $key, string $fileName, $default = null)
    {
        $data = $this->getAll($fileName);
        if (!array_key_exists($key, $data)) {
            return $default;
        }

        return $data[$key];
    }

    public function getFilePath(string $fileName): string
    {
        return $this->dataSourceDir . DIRECTORY_SEPARATOR . $fileName;
    }

    public function writeFile(string $fileName, $data): void
    {
        $saved = file_put_contents($this->getFilePath($fileName), (string)$data);
        if ($saved === false) {
            throw new DataSourceFileIoException('Could not save file');
        }
    }

    public function getAll(string $fileName): array
    {
        if (isset(self::$cache[$fileName])) {
            return self::$cache[$fileName];
        }

        $fileExt = explode('.', $fileName);
        $fileExt = strtolower(array_pop($fileExt));

        if (!in_array($fileExt, ['json', 'csv'])) {
            throw new DataSourceFileIoException('File extension not supported: ' . $fileExt);
        }

        $file = $this->getFilePath($fileName);

        try {
            $data = ($fileExt === 'csv')
                ? CsvEncoder::decodeFileAssoc($file)
                : JsonEncoder::decodeFile($file);
        } catch (\Exception $e) {
            throw new DataSourceFileIoException('Failed to parse the data file: ' . $e->getMessage());
        }

        if ($data instanceof \Traversable) {
            $data = iterator_to_array($data);
        }

        self::$cache[$fileName] = $data;

        return $data;
    }
}
