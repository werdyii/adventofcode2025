# Advent of Code 2025

My solutions to the Advent of Code 2025. Written in PHP.

## Installation

```
composer install
```

## Running test

```
./vendor/bin/pest
./vendor/bin/phpunit
composer test
composer pest
./vendor/bin/pest ./tests/DayXTest.php 
./vendor/bin/pest ./tests/DayXTest.php --colors
```

## Running opinionated PHP code style fixer for minimalists

```
./vendor/bin/pint 
composer lint
```

## Running a solution

```
composer solve <day> <puzzle> <input>
```

## Running all solutions

```
composer solve all
```

## Generating the next day

```
bash ./scaffold.sh <dayX> <session>
```