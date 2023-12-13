<?php

namespace day11;

use common\Day;

class Day11 extends Day {
    /** @var array<mixed> */
    private $map = [];
    /** @var array<mixed> */
    private $galaxies = [];
    /** @var array<mixed> */
    private $possiblePaths = [];
    /** @var array<int> */
    private $pathDistance = [];

    protected function loadData(): void {
        parent::loadData();
        $this->map = array_map(fn($r)=>str_split($r), $this->inputData);
    }
    
    private function expandUniverse(): void {
        $yAddition = 0;
        $xAddition = 0;
        foreach($this->inputData as $y => $line) {
            if(substr_count($line, ".") === strlen($line)) {
                array_splice($this->map, $y+$yAddition, 0, [$this->map[$y+$yAddition]] );
                $yAddition++;
            }
        }
        for($x=0;$x<strlen($this->inputData[0]); $x++){
            if(substr_count(implode(array_column($this->map, $x+$xAddition)), ".") === count($this->map)) {
                foreach($this->map as $y => $line) {
                    array_splice($line, $x+$xAddition, 0, "." );
                    $this->map[$y] = $line;
                }
                $xAddition++;
            }
        }
    }

    private function findGalaxies(): void {
        foreach($this->map as $y => $line) {
            $locations = array_filter($line, fn($v, $k) => $v == "#", ARRAY_FILTER_USE_BOTH );
            foreach($locations as $x => $location) {
                $this->galaxies[] = [
                    "x" => $x,
                    "y" => $y
                ];
            }
        }
    }

    private function findPossiblePaths(): void {
        $numberOfGalaxies = count($this->galaxies);
        for($i=0; $i<$numberOfGalaxies; $i++) {
            for($x=0; $x<$numberOfGalaxies; $x++) {
                if($x<= $i) continue;
                $this->possiblePaths[] = [
                    "start"=> $i,
                    "end" => $x
                ];
            }
        }
    }

    private function findShortesPaths(): void {
        foreach($this->possiblePaths as $path) {
            $start = $this->galaxies[$path["start"]];
            $end = $this->galaxies[$path["end"]];
            $distance = abs($start["x"] - $end["x"])+abs($start["y"] - $end["y"]);
            $this->pathDistance[] = $distance;
        }
    }

    public function part1(): int {
        $this->expandUniverse();
        $this->findGalaxies();
        $this->findPossiblePaths();
        $this->findShortesPaths();
        return array_sum($this->pathDistance);;
    }

    public function part2(): int {
        return 1;
    }
    
}
