<?php
namespace day2;
use common\Day;

class Day2 extends Day {
    private $gameResult = [];
    private $maxDice = [
        "red" => 12,
        "blue" => 14,
        "green" => 13
    ];

    private function checkNumberOfCubesBelowMax() {
        foreach($this->inputData as $gameKey => $line) {
            $this->gameResult[$gameKey] = $gameKey + 1;
            preg_match_all("#(\d+) ([a-zA-Z]+)#", $line, $matches);
        
            foreach($matches[1] as $index => $colorCount) {
                if($this->maxDice[$matches[2][$index]] < $colorCount) {
                    unset($this->gameResult[$gameKey]);
                }
            }
        }
    }

    public function part1(): int {
        $this->checkNumberOfCubesBelowMax();
        return array_sum($this->gameResult);
    }

    public function part2(): int {
        return 1;
    }   
}