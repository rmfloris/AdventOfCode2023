<?php

namespace day5;

use common\Day;

class Day5 extends Day {

    private $maps = [];
    private $seeds = [];
    private $locations = [];
    private $seedStack = [];

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

    private function findClosesLocation() {
        foreach($this->seeds as $seed) {
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

    private function createSeedStack() {
        for($i=0; $i<count($this->seeds); $i+=2) {
            $this->seedStack[] = [
                "mapIndex"=> -1,
                "minRange" => $this->seeds[$i], 
                "maxRange" => $this->seeds[$i]+$this->seeds[$i+1]-1
            ];
        }
    }

    private function findClosesLocationBasedOnRange() {
        $mapIndex = array_keys($this->maps);
        $targetIndex = count($mapIndex)-1;

        while(!empty($this->seedStack)) {
            $currentRange = array_pop($this->seedStack);
            // echo "<hr>CurrentRange -> ";
            // print_r($currentRange);
            if($currentRange["mapIndex"] == $targetIndex) {
                // echo "found";
                $this->locations[] = $currentRange["minRange"];
                continue;
            }
            
            foreach($this->maps[$mapIndex[$currentRange["mapIndex"]+1]] as $range) {
                $minRange = $range["sourceStart"];
                $maxRange = $range["sourceStart"]+$range["rangeLength"]-1;
                // print_r($range);
                if($currentRange["minRange"] <= $maxRange && $currentRange["maxRange"] >= $minRange) {       
                    $shiftNumbers = $range["destinationStart"] - $range["sourceStart"];
                    $matchedRange = [
                        "minRange" => max($minRange, $currentRange["minRange"]),
                        "maxRange" => min($maxRange, $currentRange["maxRange"])
                    ];
        
                    $this->seedStack[] = [
                        "mapIndex" => $currentRange["mapIndex"]+1,
                        "minRange" => $matchedRange["minRange"]+$shiftNumbers,
                        "maxRange" => $matchedRange["maxRange"]+$shiftNumbers
                    ];
        
                    // echo "AddedToStack -> ";
                    // print_r(end($this->seedStack));
        
                    if($currentRange["minRange"] < $matchedRange["minRange"]) {
                        // echo "<br>Below<br>";
                        $this->seedStack[] = [
                            "mapIndex" => $currentRange["mapIndex"],
                            "minRange" => $currentRange["minRange"],
                            "maxRange" => $matchedRange["minRange"]-1
                        ];
                        // echo "AddedToStack -> ";
                        // print_r(end($this->seedStack));
                    }
        
                    if($currentRange["maxRange"] > $matchedRange["maxRange"]) {
                        // echo "<br>Above<br>";
                        $this->seedStack[] = [
                            "mapIndex" => $currentRange["mapIndex"],
                            "minRange" => $matchedRange["maxRange"]+1,
                            "maxRange" => $currentRange["maxRange"]
                        ];
                        // echo "AddedToStack -> ";
                        // print_r(end($this->seedStack));
                    }
                    
                    continue 2;
                }
            }
            $this->seedStack[] = [
                "mapIndex" => $currentRange["mapIndex"]+1,
                "minRange" => $currentRange["minRange"],
                "maxRange" => $currentRange["maxRange"]
            ];
            // echo "AddedToStack -> ";
            // print_r(end($this->seedStack));
        }

    }

    public function part1(): int {
        $this->parseData();
        $this->findClosesLocation();
        return min($this->locations);
    }

    public function part2(): int {
        $this->parseData();
        $this->createSeedStack();
        $this->findClosesLocationBasedOnRange();
        return min($this->locations);
    }
}
