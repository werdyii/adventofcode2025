<?php

namespace Werdy\AdventOfCode2025\Day05;

use Exception;
use Illuminate\Support\Collection;

class Puzzle2
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 2.
        list( $ranges, $ingredients ) = explode("\n\n", $input);
        $ranges = (new Collection(explode("\n", $ranges)))->map(fn($line) => array_map('intval', explode("-", trim($line))));
        return $ranges
            // 1️⃣ zoradiť podľa začiatku
            ->sortBy(fn ($i) => $i[0])
            ->values()

            // 2️⃣ zlúčiť intervaly
            ->reduce(function (Collection $merged, array $current) {

                if ($merged->isEmpty()) {
                    return $merged->push($current);
                }

                [$currStart, $currEnd] = $current;
                [$lastStart, $lastEnd] = $merged->last();

                if ($currStart <= $lastEnd + 1) {
                    // prekryv alebo dotyk
                    $merged[$merged->count() - 1] = [
                        $lastStart,
                        max($lastEnd, $currEnd),
                    ];
                } else {
                    $merged->push($current);
                }

                return $merged;
            }, collect())

            // 3️⃣ spočítať veľkosť
            ->sum(fn ($i) => $i[1] - $i[0] + 1);



    }
}
