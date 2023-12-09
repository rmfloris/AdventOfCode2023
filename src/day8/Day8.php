<?php

namespace day8;

use common\Day;

class Day8 extends Day {
    private $moves = [];
    private $map = [];
	private $stepCounter = 0;
	private $currentMove = "";
	private $currentPosition = ["AAA"];

    protected function loadData(): void
    {
        parent::loadData();
        $this->extractMovesFromFirstLine();
        $this->extractMap();
    }

    private function extractMovesFromFirstLine() {
        $this->moves = str_split($this->inputData[0]);
        $this->currentMove = $this->moves[0];
    }

    private function extractMap() {
        foreach($this->inputData as $key => $mapLine) {
            if($key == 0 | $key == 1) continue;

            preg_match_all("#([0-9A-Z]{3})#", $mapLine, $matches);
            $this->map[$matches[0][0]] = [
                "L" => $matches[0][1],
                "R" => $matches[0][2]
            ];
        }
    }
	
	private function startMoving() {
        while($this->currentPosition[0] != "ZZZ") {
            $stepsIncrease = 1;
            $this->currentPosition[0] = $this->map[$this->currentPosition[0]][$this->currentMove];
            $this->updateCurrentMove();

            $this->stepCounter += $stepsIncrease;
		}
	}

    private function getPathLength($position) {
        $length = 0;
        while (!str_ends_with($position, "Z")) {

            $position = $this->map[$position][$this->currentMove];
            $this->updateCurrentMove();
            $length++;
        }
        return $length;
    }

    private function startMovingMultiple(): int {
        $pathLengths = [];
        foreach($this->currentPosition as $position) {
            $pathLengths[] = $this->getPathLength($position);
        }
        return $this->calcLcm(($pathLengths));
	}

    private function updateCurrentMove() {
        $next = next($this->moves);
        if($next !== false) {
            $this->currentMove = $next;
        } else {
            $this->currentMove = $this->moves[0];
            reset($this->moves);
        }
    }

    private function setStartPosition($lastLetter){
        $this->currentPosition = [];
        foreach($this->map as $key => $value) {
            if(substr($key,2,1) == $lastLetter) {
                $this->currentPosition[] = $key;
            }
        }
    }

    private function calcLcm($array):int {
        $answer = $array[0];
        for ($i = 1; $i < sizeof($array); $i++)
            $answer = ((($array[$i] * $answer)) / ($this->gcd($array[$i], $answer)));
        return $answer;
    }

    private function gcd($a, $b): int {
        if ($b == 0) {
            return $a;
        }
        return $this->gcd($b, $a % $b);
    }

    public function part1(): int {
        $this->startMoving();
		return $this->stepCounter;
    }

    public function part2(): int {
        $this->setStartPosition("A");
        return $this->startMovingMultiple();
    }

    
   
}
