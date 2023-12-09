<?php

namespace day9;

use common\Day;

class Day9 extends Day {
    /** @var array<int> */
    private $newHistory = [];

    /**
     * @param array<string|int> $numbers
     * @return array<int>
     */
    private function calculateDeltas($numbers) {
        $deltas = [];
        for($i=1; $i<count($numbers); $i++) {
            $deltas[] = $numbers[$i] - $numbers[$i-1];
        }
        return $deltas;
    }

    /**
     * @param array<string> $numbers
     * @return array<int>
     */
    private function getHistoryNumbers($numbers, bool $lookupRight=true) {
        $historicNumbers[] = (int) ($lookupRight ? end($numbers) : reset($numbers));
        $deltas = $this->calculateDeltas($numbers);

        while(!$this->deltasAreAllZeros($deltas)) {
            $historicNumbers[] = (int) ($lookupRight ? end($deltas) : reset($deltas));

            $deltas = $this->calculateDeltas($deltas);
        }
        return $historicNumbers;
    }
    
    /**
     * @param array<int> $numbers
     */
    private function deltasAreAllZeros($numbers): bool {
        if(empty($numbers)) { return false; }
        return (array_sum($numbers) === 0 && $numbers[0] === 0);
    }

    /**
     * @param array<int> $numbers
     */
    private function getFirstNumbersScore($numbers): int {
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
