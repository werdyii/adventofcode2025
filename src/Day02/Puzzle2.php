<?php

namespace Werdy\AdventOfCode2025\Day02;

use Exception;
use Illuminate\Support\Collection;

class Puzzle2
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 2.
        return (new Collection(explode(",", $input)))
            ->map(fn ($range) => explode("-", $range)) // Split ranges into bounds
            ->map(fn ($bounds) => $this->invalidIdsInRange((int)$bounds[0], (int)$bounds[1])) // Find invalid IDs in each range
            ->flatten() // Flatten the array of arrays
            ->sum(); // Sum counts of invalid IDs
    }

    private function invalidIdsInRange(int $from, int $to): array
    {
        $result = [];
        // echo "Finding invalid IDs in range $from to $to\n";
        $minLen = strlen((string)$from);
        $maxLen = strlen((string)$to);

        for ($len = $minLen; $len <= $maxLen; $len++) {

            for ($p = 1; $p <= intdiv($len, 2); $p++) {
                if ($len % $p !== 0) continue;

                $repeats = intdiv($len, $p);
                if ($repeats < 2) continue;

                $minPeriod = 10 ** ($p - 1);
                $maxPeriod = 10 ** $p - 1;

                for ($period = $minPeriod; $period <= $maxPeriod; $period++) {
                    $candidate = (int) str_repeat((string)$period, $repeats);

                    if ($candidate >= $from && $candidate <= $to) {
                        $result[] = $candidate;
                    }
                }
            }
        }
        // print_r($result);
        return array_unique($result);
    }

}
