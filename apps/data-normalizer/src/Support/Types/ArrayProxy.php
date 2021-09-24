<?php

declare(strict_types=1);

namespace App\Support\Types;

use App\Support\Serialization\StrFormat;
use Illuminate\Support\Arr;

/**
 * An array object that doesn't complain when an index does not exist, it just returns a default value.
 * Useful when data structure is unknown or unsure.
 */
class ArrayProxy implements \ArrayAccess
{
    private array $arr;

    public function __construct(array $arr)
    {
        $this->arr = $arr;
    }

    public function get(string $path, $default = null)
    {
        return Arr::get($this->arr, $path, $default);
    }

    public function getSlug(string $path, $default = null): ?string
    {
        $val = Arr::get($this->arr, $path, null);
        if ($val === null) {
            return $default;
        }

        return StrFormat::slug($val);
    }

    public function getInt(string $path, $default = null): ?int
    {
        $val = Arr::get($this->arr, $path, null);
        if ($val === null) {
            return $default;
        }

        return (int)$val;
    }

    public function getFloat(string $path, $default = null): ?float
    {
        $val = Arr::get($this->arr, $path, null);
        if ($val === null) {
            return $default;
        }

        return (float)$val;
    }

    public function getBool(string $path, $default = false): ?bool
    {
        $val = Arr::get($this->arr, $path, null);
        if ($val === null) {
            return $default;
        }

        return (bool)$val;
    }

    public function offsetExists($offset)
    {
        return Arr::exists($this->arr, $offset);
    }

    public function offsetGet($offset)
    {
        return Arr::get($this->arr, $offset);
    }

    public function offsetSet($offset, $value)
    {
        return Arr::set($this->arr, $offset, $value);
    }

    public function offsetUnset($offset)
    {
        Arr::forget($this->arr, $offset);
    }
}
