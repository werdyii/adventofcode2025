<?php

namespace Werdy\AdventOfCode2025\Day06;

use Exception;
use Illuminate\Support\Collection;

class Puzzle2
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 2.
        $worksheet = (new Collection(explode("\n", $input)))
            ->map(fn ($line) => str_split($line));

        $operatorLine = $worksheet->pop();
        $rowsCount = $worksheet->count();
        $start = $columnsCount = count($worksheet->first());
        $totalSum = 0;

        for ($c = $columnsCount - 1; $c >= 0; $c--) {

            $op = $operatorLine[$c] ?? ' ';
            echo "Processing column {$c} with operator '{$op}'\n";
            if ($op !== '+' && $op !== '*') {
                continue;
            }

            $lenth = $start - $c;
            echo "Lenth: $lenth \n";

            for ($i = 0; $i < $lenth; $i++) {
                $numbers = [];

                for ($r = 0; $r < $rowsCount; $r++) {
                    $ch = $worksheet[$r][$c + $i] ?? ' ';
                    if (ctype_digit($ch)) {
                        $numbers[$r] = (int) $ch;
                    }
                }

                $values[] = (int) implode('', $numbers);
            }
            echo 'Values: '.implode(', ', $values)."\n";
            if ($op === '+') {
                $columnValue = array_sum($values);
            } else {
                $columnValue = array_product($values);
            }
            echo "Column value: $columnValue\n\n";
            $totalSum += $columnValue;
            $start = $c - 1;
            $values = [];
        }

        return $totalSum;
    }
}
