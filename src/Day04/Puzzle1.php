<?php

namespace Werdy\AdventOfCode2025\Day04;

use Exception;
use Illuminate\Support\Collection;

class Puzzle1
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 1.
        $grid = (new Collection(explode("\n", $input)))->map(
            fn (string $line) => str_split($line)
        );

        $rows = $grid->count();
        $cols = count($grid->first());

        $dirs = [
            [-1, -1], [-1, 0], [-1, 1],
            [0, -1],          [0, 1],
            [1, -1], [1, 0], [1, 1],
        ];

        return $grid->reduce(
            function (int $total, array $row, int $r) use ($grid, $rows, $cols, $dirs) {

                return $total + collect($row)->reduce(
                    function (int $rowSum, string $cell, int $c) use ($grid, $r, $rows, $cols, $dirs) {

                        if ($cell !== '@') {
                            return $rowSum;
                        }

                        $neighbors = 0;

                        foreach ($dirs as [$dr, $dc]) {
                            $nr = $r + $dr;
                            $nc = $c + $dc;

                            if (
                                $nr >= 0 && $nr < $rows &&
                                $nc >= 0 && $nc < $cols &&
                                $grid[$nr][$nc] === '@'
                            ) {
                                $neighbors++;
                            }
                        }

                        return $neighbors < 4
                            ? $rowSum + 1
                            : $rowSum;
                    },
                    0
                );
            },
            0
        );

    }
}
