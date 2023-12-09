<?php

namespace day9;

use common\Day;

class Day9 extends Day {
    private $newHistory = [];

    private function calculateDeltas($numbers) {
        $deltas = [];
        for($i=1; $i<count($numbers); $i++) {
            $deltas[] = $numbers[$i] - $numbers[$i-1];
        }
        return $deltas;
    }

    private function getLastNumbers($numbers) {
        $lastNumbers[] = end($numbers);
        $deltas = $this->calculateDeltas($numbers);

        while(!$this->deltasAreAllZeros($deltas)) {
            // echo "inside loop";
            $lastNumbers[] = end($deltas);

            $deltas = $this->calculateDeltas($deltas);
        }
        return $lastNumbers;
    }
    
    private function deltasAreAllZeros($numbers) {
        if(empty($numbers)) { return false; }
        return (array_sum($numbers) === 0 && $numbers[0] === 0);
    }

    private function getScore($lastNumbers) {
        $prevLast = 0;
        foreach($lastNumbers as $lastNumber) {
            $prevLast = $lastNumber + $prevLast;
        }
        // echo "prevLast: ". $prevLast ."<br>";
        return $prevLast;
    }

    public function part1(): int {
        foreach($this->inputData as $line) {
            $numbers = explode(" ", $line);
            $lastNumbers = $this->getLastNumbers($numbers);
            // print_r($lastNumbers);
            $this->newHistory[] = array_sum($lastNumbers);
            // $this->newHistory[] = $this->getScore($lastNumbers);

        }
        // print_r($this->newHistory);
        return array_sum($this->newHistory);

        /**
         * right answer: 1993300041
         */
    }

    public function part2(): int {
        return 1;
    }
    
}
