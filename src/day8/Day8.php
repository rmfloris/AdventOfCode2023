<?php

namespace day8;

use common\Day;

class Day8 extends Day {
    /** @var array<string> */
    private $moves = [];
    /** @var array<mixed> */
    private $map = [];
	private int $stepCounter = 0;
	private string $currentMove = "";
    /** @var array<string> */
	private $currentPosition = ["AAA"];

    protected function loadData(): void
    {
        parent::loadData();
        $this->extractMovesFromFirstLine();
        $this->extractMap();
    }

    private function extractMovesFromFirstLine(): void {
        $this->moves = str_split($this->inputData[0]);
        $this->currentMove = $this->moves[0];
    }

    private function extractMap(): void {
        foreach($this->inputData as $key => $mapLine) {
            if($key == 0 | $key == 1) continue;

            preg_match_all("#([0-9A-Z]{3})#", $mapLine, $matches);
            $this->map[$matches[0][0]] = [
                "L" => $matches[0][1],
                "R" => $matches[0][2]
            ];
        }
    }
	
	private function startMoving(): void {
        while($this->currentPosition[0] != "ZZZ") {
            $this->currentPosition[0] = $this->map[$this->currentPosition[0]][$this->currentMove];
            $this->updateCurrentMove();

            $this->stepCounter += 1;
		}
	}

    private function getPathLength(string $position): int {
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

    private function updateCurrentMove(): void {
        if(next($this->moves)) { 
            $this->currentMove = current($this->moves);
        } else {
            $this->currentMove = reset($this->moves);            
        }
    }

    private function setStartPosition(string $lastLetter): void{
        $this->currentPosition = array_filter(array_keys($this->map), fn($k) => str_ends_with($k, $lastLetter));
    }

    /**
     * @param array<mixed> $array
     */
    private function calcLcm($array):int {
        $answer = $array[0];
        for ($i = 1; $i < sizeof($array); $i++)
            $answer = ((($array[$i] * $answer)) / ($this->gcd($array[$i], $answer)));
        return $answer;
    }

    private function gcd(int $a, int $b): int {
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
