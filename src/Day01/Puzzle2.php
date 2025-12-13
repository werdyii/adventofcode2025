<?php

namespace Werdy\AdventOfCode2025\Day01;

use Exception;
use Illuminate\Support\Collection;

class Puzzle2
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 2.
        echo "The dial starts by pointing at 50.\n";

        return (new Collection(explode("\n", $input)))->reduce(function ($state, $move) {

            if ($move === '') {
                return $state;
            }

            echo "The dial is rotated [$move]";

            // Parsovanie
            $direction = $move[0];
            $value = (int) substr($move, 1);

            // Delta cez ternár (bez if-u)
            $delta = ($direction === 'R') ? $value : -$value;

            $current = $state['current'];
            $zeroHits = $state['zeroHits'];

            // 1. plné rotácie
            $zeroHits += intdiv(abs($delta), 100);

            // 2. zvyšok. Pohyb (0-99) a kontrola prechodu cez 0
            $remainder = $delta % 100;

            if ($remainder !== 0) {
                $start = $current;
                $end = $current + $remainder;

                if (
                    ($remainder > 0 && $start < 100 && $end >= 100) ||
                    ($remainder < 0 && $start > 0 && $end <= 0)
                ) {
                    $zeroHits++;
                }
            }

            // 3. finálna pozícia
            $current = (($current + $delta) % 100 + 100) % 100;
            echo " to position at [$current]. Total zero hits so far: [$zeroHits].\n";

            return [
                'current' => $current,
                'zeroHits' => $zeroHits,
            ];

        }, [
            'current' => 50,
            'zeroHits' => 0,
        ])['zeroHits'];

    }
}
