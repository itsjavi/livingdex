<?php

declare(strict_types=1);

namespace App\Support\Math;

class PercentileRankCalculator
{
    /**
     * Calculate percentile rank over a field in a collection of associative arrays
     * @param array[]    $collection
     * @param int|string $analysedKey
     * @param int|string $newPercentileKey
     * @param int        $percentileMax
     * @return array Returns back the collection with the new percentile property in every item.
     * The returned collection is sorted by $analysedKey. Original collection array keys are discarded.
     */
    public function calculate(
        array $collection,
        int|string $analysedKey,
        int|string $newPercentileKey,
        $percentileMax = 100
    ): array {
        // Sort provided data in ascending order
        $collection = self::sort($collection, $analysedKey);

        // Generate an array of values
        // Make sure values are of the same type
        $values = [];
        foreach ($collection as $i => $arr) {
            $values[] = (string)(float)$arr[$analysedKey];
        }

        // Number of examinees in the sample
        $count = count($values);

        // Array to use when checking scores less than the score of interest
        $count_less = array_flip(array_unique($values));

        // Array to use when checking frequency of the score of interest
        $count_values = array_count_values($values);

        foreach ($values as $i => $value) {
            $freq = $count_values[$value];
            $collection[$i][$newPercentileKey] = (($count_less[$value] + 0.5 * $freq) / $count) * $percentileMax;
        }

        return $collection;
    }

    /**
     * Sort array in ascending order
     * @param array      $data
     * @param int|string $index
     * @return array
     */
    protected static function sort(array $data, int|string $index): array
    {
        usort(
            $data,
            static function ($a, $b) use ($index) {
                $item1 = (string)(float)$a[$index];
                $item2 = (string)(float)$b[$index];

                if ($item1 == $item2) {
                    return 0;
                }

                return ($item1 < $item2) ? -1 : 1;
            }
        );

        return $data;
    }
}
