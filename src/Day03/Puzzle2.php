<?php

namespace Werdy\AdventOfCode2025\Day03;

use Exception;
use Illuminate\Support\Collection;

class Puzzle2
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 2.
        return (new Collection(explode("\n", $input)))
            ->map(fn ($bank) => $this->maxShockK($bank))
                ->sum();
    }

    private function maxShockK(string $s, int $k = 12): int
    {
        $digits = str_split($s);
        $n = count($digits);

        if ($n <= $k) {
            return (int) $s;
        }

        $toRemove = $n - $k;
        $stack = [];

        foreach ($digits as $d) {
            while (
                $toRemove > 0 &&
                !empty($stack) &&
                end($stack) < $d
            ) {
                array_pop($stack);
                $toRemove--;
            }
            $stack[] = $d;
        }

        // ak sme ešte neodstránili dosť, odstráň zozadu
        if ($toRemove > 0) {
            $stack = array_slice($stack, 0, count($stack) - $toRemove);
        }
        // echo implode('', array_slice($stack, 0, $k)) . "\n";
        return (int) implode('', array_slice($stack, 0, $k));
    }

}
