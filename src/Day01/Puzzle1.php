<?php

namespace Werdy\AdventOfCode2025\Day01;

use Exception;
use Illuminate\Support\Collection;

class Puzzle1
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 1.
        return (new Collection(explode("\n", $input)))->reduce(function ($state, $move) {

            if ($move === '') {
                return $state;
            }

            $current = $state['current'];
            $zeroHits = $state['zeroHits'];

            // Parsovanie
            $direction = $move[0];
            $value = (int) substr($move, 1);

            // Delta cez ternár (bez if-u)
            $delta = ($direction === 'R') ? $value : -$value;

            // Pohyb + modulo normalizácia do 0–99
            $current = (($current + $delta) % 100 + 100) % 100;

            // Započítanie zásahu 0 (jediná kontrola, tá musí byť)
            $zeroHits += ($current === 0);

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
