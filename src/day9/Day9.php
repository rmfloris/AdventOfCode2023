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

    private function getHistoryNumbers($numbers, $lookupRight=true) {
        // $data = ($lookupRight ? "end" : "Begin");
        // echo "--". $data ."--<br>";
        $historicNumbers[] = ($lookupRight ? end($numbers) : reset($numbers));
        $deltas = $this->calculateDeltas($numbers);

        while(!$this->deltasAreAllZeros($deltas)) {
            // echo "inside loop";
            $historicNumbers[] = ($lookupRight ? end($deltas) : reset($deltas));
            // $lastNumbers[] = end($deltas);

            $deltas = $this->calculateDeltas($deltas);
        }
        // print_r($historicNumbers);
        return $historicNumbers;
    }
    
    private function deltasAreAllZeros($numbers) {
        if(empty($numbers)) { return false; }
        return (array_sum($numbers) === 0 && $numbers[0] === 0);
    }

    private function getFirstNumbersScore($numbers) {
        $result = 0;
        foreach(array_reverse($numbers) as $number) {
            $result = $number - $result;
        }
        return $result;
    }

    public function part1(): int {
        foreach($this->inputData as $line) {
            $numbers = explode(" ", $line);
            $lastNumbers = $this->getHistoryNumbers($numbers);
            $this->newHistory[] = array_sum($lastNumbers);
        }
        return array_sum($this->newHistory);
    }

    public function part2(): int {
        foreach($this->inputData as $line) {
            $numbers = explode(" ", $line);
            $lastNumbers = $this->getHistoryNumbers($numbers, false);
            $this->newHistory[] = $this->getFirstNumbersScore($lastNumbers);
        }

        // print_r($this->newHistory);
        return array_sum($this->newHistory);
    }
    
}
