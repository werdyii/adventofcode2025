<?php

namespace Werdy\AdventOfCode2025\Day02;

use Exception;
use Illuminate\Support\Collection;

class Puzzle1
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 1.
        return (new Collection(explode(",", $input)))
            ->map(fn ($range) => explode("-", $range)) // Split ranges into bounds
            ->map(fn ($bounds) => $this->findInvalidIds((int)$bounds[0], (int)$bounds[1])) // Find invalid IDs in each range
            ->flatten() // Flatten the array of arrays
            ->sum(); // Sum counts of invalid IDs

    }

    private function isInvalidId(int $id): bool
    {
        $s = (string) $id;
        $len = strlen($s);

        if ($len % 2 !== 0) {
            return false;
        }

        $half = $len / 2;

        return substr($s, 0, $half) === substr($s, $half);
    }

    private function findInvalidIds(int $from, int $to): array
    {
        $invalid = [];

        for ($i = $from; $i <= $to; $i++) {
            if ($this->isInvalidId($i)) {
                $invalid[] = $i;
            }
        }

        return $invalid;
    }
}
