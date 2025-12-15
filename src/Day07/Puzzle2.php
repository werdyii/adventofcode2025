<?php

namespace Werdy\AdventOfCode2025\Day07;

use Exception;
use Illuminate\Support\Collection;

class Puzzle2
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 2.
        return new Collection(explode("\n", $input));
    }
}
