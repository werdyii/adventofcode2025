<?php

namespace Werdy\AdventOfCode2025\Day07;

use Exception;
use Illuminate\Support\Collection;

class Puzzle2
{
    private Collection $manifold;
    // Memoizácia: Pole na uloženie výsledkov [y][x]
    private array $memo = []; 

    public function __invoke(string $fileName): int
    {
        $input = file_get_contents(__DIR__.'/'.$fileName)
            ?: throw new Exception('Failed to read input file.');

        // Inicializácia mapy ako 2D kolekcie
        $this->manifold = (new Collection(explode("\r\n", $input)))
            ->map(fn ($line) => collect(str_split($line)));

        // Vyhľadanie štartovacieho bodu 'S' v prvom riadku
        $startX = $this->manifold[0]->search('S');

        // Spustenie rekurzie na počítanie ciest
        // Počet ciest zo štartu (startX, 0) do konca (počítané vnútri rekurzie)
        return $this->pocitajCasoveLinie($startX, 0); 
    }

    /**
     * Rekurzívne spočíta počet časových línií z bodu (x, y) do konca.
     */
    private function pocitajCasoveLinie(int $x, int $y): int
    {
        // 1. Kontrola memoizácie
        // Ak sme už výsledok pre (x, y) vypočítali, vrátime ho
        if (isset($this->memo[$y][$x])) {
            // echo "Using memoized value for ($x, $y): " . $this->memo[$y][$x] . "\n"; // Debug výpis
            return $this->memo[$y][$x];
        }

        $rows = $this->manifold->count();
        $cols = $this->manifold[0]->count();

        // 2. Základný prípad: Koniec rozdeľovača
        // Ak sme v poslednom riadku, existuje odtiaľto 1 cesta (samotný cieľ)
        if ($y == $rows - 1) {
            return 1;
        }

        // 3. Extrakcia stavu
        $dole_y = $y + 1;
        $cell = $this->manifold[$y][$x];
        $dole_cell = $this->manifold[$dole_y][$x];

        $pocet_ciest = 0;

        // Logika pohybu:
        // echo "Calculating paths from ($x, $y) cell $cell, dole $dole_cell\n";    
        // Ak je to 'S' alebo 'potrubie' ('|') a pod ním je potrubie/delič.
        // V diagrame to vyzerá, že pohyb pokračuje DOLE ('|')
        if ($dole_cell !== '^') {
            // echo "Moving down from ($x, $y) to ($x, $dole_y)\n";
            // Pokračujeme len dole, do (x, y+1)
            $pocet_ciest += $this->pocitajCasoveLinie($x, $dole_y);
            
        } else{
            // Ak je pod nami DELIČ/VETVENIE, ideme doľava aj doprava.
            // Kontrola hraníc pre vetvenie:
            // echo "Branching at ($x, $y) down to ($x, $dole_y)\n";
            
            // Vetva 1: Doľava
            if ($x > 0) {
                // echo "Moving left from ($x, $y) to (" . ($x - 1) . ", $dole_y)\n";
                $pocet_ciest += $this->pocitajCasoveLinie($x - 1, $dole_y);
            }
            
            // Vetva 2: Doprava
            if ($x < $cols - 1) {
                // echo "Moving right from ($x, $y) to (" . ($x + 1) . ", $dole_y)\n";
                $pocet_ciest += $this->pocitajCasoveLinie($x + 1, $dole_y);
            }
        }
        
        // Váš kód neobsahoval spracovanie vetvenia (^) na AKTUALNOM riadku,
        // čo je potrebné, ak by sa mohla častica pohybovať diagonálne.
        // Podľa diagramu to však vyzerá, že pohyb je vždy z '|' v riadku Y do X v riadku Y+1

        // 4. Uloženie výsledku (Memoizácia)
        // echo "Memoizing [$y][$x] = $pocet_ciest\n"; // Debug výpis
        $this->memo[$y][$x] = $pocet_ciest;
        return $pocet_ciest;
    }
}