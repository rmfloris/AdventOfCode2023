<?php

namespace day5;

use common\Day;
use common\Helper;

class Day5 extends Day {

    private $maps = [];
    private $seeds = [];
    private $seedsRange = [];
    private $locations = [];

    private function parseData() {
        $map = '';
        foreach($this->inputData as $key => $line) {
            if($key === 0) {
                preg_match_all('/\d+/', $line, $matches);
                $this->seeds = $matches[0];
            } elseif (preg_match('/\w+-to-\w+/', $line, $matches)) {
                $map = $matches[0];
            } elseif (!empty($line)) {
                preg_match('/(\d+) (\d+) (\d+)/', $line, $matches);
                $this->maps[$map][] = [
                    'destinationStart' => $matches[1],
                    'sourceStart' => $matches[2],
                    'rangeLength' => $matches[3],
                ];
            }
        }
    }

    private function findClosesLocation($seeds) {
        // foreach($this->seeds as $seed) {
        foreach($seeds as $seed) {
            $originalSeed = $seed;
            foreach($this->maps as $key => $map) {
                foreach($map as $range) {
                    if($seed >= $range["sourceStart"] && $seed < ($range["sourceStart"] + $range["rangeLength"])) {
                        $newSeed = $seed + $range["destinationStart"] - $range["sourceStart"];
                        $seed = $newSeed;
                        // echo "start: ". $range["sourceStart"] ."<br>";
                        // echo "map: ". $key ."<br>";
                        // echo "length: ". $range["rangeLength"] ."<br>";
                        // echo "seed: ". $seed ."<br>"; 
                        // echo "new: ". $newSeed ."<br><br>";
                        
                        break;
                    }
                }
            }
        
            $this->locations[$originalSeed] = $seed;
        }
    }

    private function seedsToRanges() {
        
        for($i=0;$i<count($this->seeds); $i+=2){
            
            $seed = $this->seeds[$i];
            // echo "seend: ". $seed;
            $range = $this->seeds[$i+1];
            // echo "range: ". $range;
            for($x=$seed; $x<$seed+$range; $x++) {
                $this->seedsRange[] = $x;
            }
        }
    }

    public function part1(): int {
        $this->parseData();
        $this->findClosesLocation($this->seeds);
        return min($this->locations);
    }

    public function part2(): int {
        $this->parseData();
        $this->seedsToRanges();
        // Helper::printRFormatted($this->seedsRange);
        $this->findClosesLocation($this->seedsRange);
        return min($this->locations);
    }
    
}
