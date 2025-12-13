<?php

test('returns the correct answer for puzzle_1 example_1', function () {
    $result = (new Werdy\AdventOfCode2025\Day03\Puzzle1)('example1.txt');
    expect($result)->toBe(357);
});

test('returns the correct answer for puzzle_2 example_2', function () {
    $result = (new Werdy\AdventOfCode2025\Day03\Puzzle2)('example2.txt');
    expect($result)->toBe(3121910778619);
});
