<?php

namespace Werdy\AdventOfCode2025\Day03;

use Exception;
use Illuminate\Support\Collection;

class Puzzle1
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 1.
        return (new Collection(explode("\n", $input)))
            ->map(fn ($bank) => $this->maxShock($bank))
                ->sum();
    }

    private function maxShock(string $s): int
    {
        $digits = array_map('intval', str_split($s));
        $n = count($digits);

        // suffix max: najväčšia číslica napravo
        $suffixMax = array_fill(0, $n, -1);
        $suffixMax[$n - 1] = -1;

        for ($i = $n - 2; $i >= 0; $i--) {
            $suffixMax[$i] = max($digits[$i + 1], $suffixMax[$i + 1]);
        }

        $best = 0;

        for ($i = 0; $i < $n - 1; $i++) {
            if ($suffixMax[$i] !== -1) {
                $candidate = 10 * $digits[$i] + $suffixMax[$i];
                $best = max($best, $candidate);
            }
        }

        return $best;
    }
}
