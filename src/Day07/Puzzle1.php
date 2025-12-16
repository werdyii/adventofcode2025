<?php

namespace Werdy\AdventOfCode2025\Day07;

use Exception;
use Illuminate\Support\Collection;

class Puzzle1
{
    public function __invoke(string $fileName)
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // TODO: Solve puzzle 1.
        $tachyonManifold = (new Collection(explode("\r\n", $input)))
            ->map(fn ($line) => collect(str_split($line)));

        $splitterCount = 0;

        foreach($tachyonManifold as $y => $line) {
            foreach($line as $x => $cell) {
                if ($y +1 >=  $tachyonManifold->count()) {
                    continue;
                }
                if (($cell === 'S') || ($cell === '|' && $tachyonManifold[$y+1][$x] === ".") ) {
                    $tachyonManifold[$y+1][$x] = "|";
                } elseif ($cell === '|' && $tachyonManifold[$y+1][$x] === "^" ){
                    if(($x+1) < $line->count()) {
                        $tachyonManifold[$y+1][$x+1] = "|";
                    };
                    if (($x-1) >= 0) {
                        $tachyonManifold[$y+1][$x-1] = "|";
                    }
                    $splitterCount++;
                }
            }
            // echo implode("", $tachyonManifold[$y]->toArray()) . "[".$splitterCount."]\n";
        }

        return $splitterCount;
    }
}
