<?php

namespace Werdy\AdventOfCode2025\Day12;

use Exception;
use Illuminate\Support\Collection;

class Puzzle1
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 1.
        return new Collection(explode("\n", $input));
    }
}
