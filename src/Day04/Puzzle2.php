<?php

namespace Werdy\AdventOfCode2025\Day04;

use Exception;
use Illuminate\Support\Collection;

class Puzzle2
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 2.
        $grid = (new Collection(explode("\n", $input)))
            ->map(fn (string $line) => str_split($line))
            ->values();

        $dirs = collect([
            [-1, -1], [-1, 0], [-1, 1],
            [0, -1],          [0, 1],
            [1, -1], [1, 0], [1, 1],
        ]);

        $rows = $grid->count();
        $cols = count($grid->first());

        $totalRemoved = 0;

        while (true) {

            // 1️ nájdi všetky pozície na odstránenie
            $toRemove = $grid->map(function ($row, $r) use ($grid, $dirs, $rows, $cols) {
                return collect($row)->map(function ($cell, $c) use ($grid, $dirs, $r, $rows, $cols) {

                    if ($cell !== '@') {
                        return false;
                    }

                    $neighbors = $dirs->filter(function ($d) use ($grid, $r, $c, $rows, $cols) {
                        [$dr, $dc] = $d;
                        $nr = $r + $dr;
                        $nc = $c + $dc;

                        return
                            $nr >= 0 && $nr < $rows &&
                            $nc >= 0 && $nc < $cols &&
                            $grid[$nr][$nc] === '@';
                    })->count();

                    return $neighbors < 4;
                });
            });

            // 2️ spočítaj, koľko ich je
            $countThisRound = $toRemove
                ->flatten()
                ->filter()
                ->count();

            if ($countThisRound === 0) {
                break;
            }

            $totalRemoved += $countThisRound;

            // 3️ aplikuj zmeny (x → .)
            $grid = $grid->map(function ($row, $r) use ($toRemove) {
                return collect($row)->map(function ($cell, $c) use ($toRemove, $r) {
                    return $toRemove[$r][$c] ? '.' : $cell;
                })->toArray();
            });
        }

        return $totalRemoved;

    }
}
