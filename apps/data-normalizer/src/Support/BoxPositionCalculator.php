<?php

declare(strict_types=1);

namespace App\Support;

class BoxPositionCalculator
{
    /**
     * Given the sequential index of the element in a flattened list,
     * calculates the position of the element in a list of grids, given each grid dimensions.
     *
     * @param int $sequentialIndex
     * @param int $gridRows
     * @param int $gridColumns
     * @return array ['debug' => string, 'box' => int, 'column' => int, 'row' => int]
     */
    public function calculate(int $sequentialIndex, int $gridRows = 5, int $gridColumns = 6): array
    {
        $i = -1;
        $grid = 0;
        $col = 0;
        $row = 0;
        $debug = "\n";

        while ($i < $sequentialIndex) {
            // new line
            if (($col + 1) > $gridColumns) {
                $col = 0;
                $row++;
                $debug .= "\n";
            } else {
                $i++;
                if ($i === $sequentialIndex) {
                    $debug .= " * \n\n";
                    break;
                }
                $debug .= " - ";
                $col++;
            }

            // new box
            if (($row + 1) > $gridRows) {
                $grid++;
                $row = 0;
                $col = 0;
                $debug .= "\n\n";
            }
        }

        return ['debug' => $debug, 'grid' => $grid, 'column' => $col, 'row' => $row];
    }
}
