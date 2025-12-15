<?php

test('returns the correct answer for puzzle_1 example_1', function () {
    $result = (new Werdy\AdventOfCode2025\Day06\Puzzle1)('example1.txt');
    expect($result)->toBe(4277556);
});

test('returns the correct answer for puzzle_2 example_2', function () {
    $result = (new Werdy\AdventOfCode2025\Day06\Puzzle2)('example2.txt');
    expect($result)->toBe(3263827);
});
