<?php

namespace Werdy\AdventOfCode2025\Day06;

use Exception;
use Illuminate\Support\Collection;

class Puzzle1
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 1.
        $return = (new Collection(explode("\n", $input)))
            ->map(
                fn (string $line) => collect(explode(' ', $line))
                    ->filter(fn (string $part) => $part !== '')
                    ->values()
            );
        $columns = count($return->first());
        $rows = $return->count();
        $sum = 0;
        for ($c = 0; $c < $columns; $c++) {
            $sumCol = 0;
            for ($r = 0; $r < $rows - 1; $r++) {
                // echo "Riadok: {$r}, Stlpec: {$c}, znamienko {$return[$rows-1][$c]}, hodnota {$return[$r][$c]}, sucet stlpcu: {$sumCol} celkovy: {$sum}\n";
                if ($return[$rows - 1][$c] === '+') {
                    $sumCol += (int) $return[$r][$c];
                } elseif ($sumCol == 0) {
                    $sumCol = (int) $return[$r][$c];
                } else {
                    $sumCol *= (int) $return[$r][$c];
                }
            }
            $sum += $sumCol;
        }

        return $sum;
    }
}
