<?php

namespace Werdy\AdventOfCode2025\Day05;

use Exception;
use Illuminate\Support\Collection;

class Puzzle1
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 1.
        list( $ranges, $ingredients ) = explode("\n\n", $input);
        $ranges = (new Collection(explode("\n", $ranges)))->map(fn($line) => array_map('intval', explode("-", trim($line))));
        $ingredients = (new Collection(explode("\n", $ingredients)))->map(fn($line) => intval(trim($line)));
        
        return $ingredients
            ->reduce(function (int $sum, int $ingredient) use ($ranges) {
                // echo "\nChecking ingredient: $ingredient\n";
                foreach ($ranges as $range) {
                    // echo " - Against range: {$range[0]}-{$range[1]}\n";
                    if ($ingredient >= $range[0] && $ingredient <= $range[1]) {
                        $sum++;
                        break;
                    }
                };
                // echo " => Current sum: $sum\n\n";
                return $sum;
            }, 0);
    }
}
