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
    private $minDice = [];

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

    private function getMinimumCubes() {
        foreach($this->inputData as $gameKey => $line) {
            $this->minDice[$gameKey] = [];
            preg_match_all("#(\d+) ([a-zA-Z]+)#", $line, $matches);
        
            foreach($matches[1] as $index => $colorCount) {
                $color = $matches[2][$index];
                if(!array_key_exists($color, $this->minDice[$gameKey])) {
                    $this->minDice[$gameKey][$color] = $colorCount;
                } elseif($colorCount > $this->minDice[$gameKey][$color]) {
                    $this->minDice[$gameKey][$color] = $colorCount;
                }  
            }
        }
    }

    private function getGameResult() {
        $gameResult = 0;
        foreach($this->minDice as $game) {
            $gameResult += array_product($game);
        }
        return $gameResult;
    }

    public function part1(): int {
        $this->checkNumberOfCubesBelowMax();
        return array_sum($this->gameResult);
    }

    public function part2(): int {
        $this->getMinimumCubes();

        return $this->getGameResult();
    }   
}