<?php

namespace day8;

use common\Day;

class Day8 extends Day {
    private $moves = [];
    private $map = [];
	private $stepCounter = 0;
	private $currentMove = "";
	private $currentPosition = "AAA";
    // private $stack = [];

    private function parseData() {
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

            preg_match_all("#([A-Z]{3})#", $mapLine, $matches);
            $this->map[$matches[0][0]] = [
                "L" => $matches[0][1],
                "R" => $matches[0][2]
            ];
        }
    }
	
	private function startMoving() {
		$i=1;
        
        while($this->currentPosition != "ZZZ") {
            $stepsIncrease = 1;
            $this->currentPosition = $this->map[$this->currentPosition][$this->currentMove];
            $this->updateCurrentMove();

            $this->stepCounter += $stepsIncrease;
		
			if($i == 1000000) {
				break;
			}
			$i++;
		}
	}

    // private function checkStack($position, $move) {
    //     return (isset($this->stack[$position][$move]) ? $this->stack[$position][$move] : 0);
    // }

    // private function updateStack() {
    //     $this->stack[$this->currentPosition][$this->currentMove] = 1;
    //     return 1;
    // }

    private function updateCurrentMove($increase = 1) {
        for($i=0; $i<$increase; $i++) {
            $next = next($this->moves);
            if($next !== false) {
                $this->currentMove = $next;
            } else {
                $this->currentMove = $this->moves[0];
                reset($this->moves);
            }
        }
    }

    public function part1(): int {
        $this->parseData();
        $this->startMoving();
		return $this->stepCounter;
    }

    public function part2(): int {
        return 1;
    }
    
}
