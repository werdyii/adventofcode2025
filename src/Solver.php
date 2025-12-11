<?php

namespace Werdy\AdventOfCode2025;

use Illuminate\Support\Collection;

require __DIR__.'/../vendor/autoload.php';

class Solver
{
    public static function solve(\Composer\Script\Event $event): void
    {
        $args = $event->getArguments();

        switch (count($args)) {
            case 1:
                if ($args[0] === 'all') {
                    self::runAll();
                } else {
                    self::run($args[0], 1);
                    self::run($args[0], 2);
                }
                break;
            case 2:
                self::run($args[0], $args[1]);
                break;
            case 3:
                self::run($args[0], $args[1], $args[2]);
                break;

            default:
                self::info('Use: composer solve <day> <puzzle> <inputFileName>');
                break;
        }
    }

    private static function runAll(): void
    {
        $startTime = microtime(true);
        (new Collection(scandir(__DIR__)))
            ->filter(fn (string $dir) => str_starts_with($dir, 'Day'))
            ->map(fn (string $dir) => substr($dir, 3))
            ->sort(SORT_NUMERIC)
            ->each(function (string $day) {
                self::run($day, '1');
                self::info('');
                self::run($day, '2');
                self::info('');
            });
        $endTime = microtime(true);

        $elapsed = round($endTime - $startTime, 4);
        self::success("Completed all solutions in $elapsed seconds.");
    }

    private static function run($day, $puzzle, $inputFileName = 'input.txt'): void
    {
        $day = str_pad((string) $day, 2, '0', STR_PAD_LEFT);

        $class = "Werdy\\AdventOfCode2025\\Day$day\\Puzzle$puzzle";
        if (! class_exists($class)) {
            self::error("Could not find class to solve Day $day Puzzle $puzzle.");
            self::info("Tried to instantiate: $class");
            exit(1);
        }

        $instance = new $class;
        if (! is_callable($instance)) {
            self::error("Instantiated class is not callable: $class");
            exit(1);
        }

        $prettyDay = str_pad($day, 2, '0', STR_PAD_LEFT);
        self::info("========= Day $prettyDay, Puzzle $puzzle =========");

        $startTime = microtime(true);
        self::success($instance($inputFileName));
        $endTime = microtime(true);

        $elapsed = round($endTime - $startTime, 4);
        self::info("Completed in $elapsed seconds.");
        self::info('====================================');
    }

    private static function success(string $message): void
    {
        echo "\033[01;32m  $message  \033[0m\n";
    }

    private static function error(string $message): void
    {
        echo "\033[01;31m  $message  \033[0m\n";
    }

    private static function info(string $message): void
    {
        echo "  $message  \n";
    }
}
