<?php
namespace day1;
use common\Day;
use common\Helper;

class Day1 extends Day {
    /**
    * @return array<int>
    */
    private function getFirstAndLastNumber($inputData) {
        $numbersArray = [];
        foreach($inputData as $line) {
            preg_match_all("#\d#", $line, $matches);
            $numbersArray[] = $this->combineStrings($matches[0][0], end($matches[0]));
        }
        return $numbersArray;
    }

    private function combineStrings(string $firstValue, string $secondValue): string {
        return $firstValue . $secondValue;
    }

    private function summation($numbersArray) {
        return array_sum($numbersArray);
    }

    private function getFirstAndLastNumberV2($inputData) {
        $numbersAsStringOptions = [
            "one" => 1,
            "two" => 2,
            "three" => 3,
            "four" => 4,
            "five" => 5,
            "six" => 6,
            "seven" => 7,
            "eight" => 8,
            "nine" => 9,
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9
        ];
        $numbersArray = [];
        foreach($inputData as $line) {
            $positions = [];
            foreach($numbersAsStringOptions as $numberToFind => $numbericValue) {
                $start = 0;
                while(($pos = strpos(($line),$numberToFind,$start)) !== false) {
                    $start = $pos+1; // start searching from next position.
                    $positions[$pos] = $numbericValue;
                }
            }
            ksort($positions);
            reset($positions);
            $numbersArray[] = $this->combineStrings(current($positions), end($positions));
        }
        return $numbersArray;
    }

    public function part1(): int {
        return $this->summation($this->getFirstAndLastNumber($this->inputData));
    }

    public function part2(): int {
        return $this->summation($this->getFirstAndLastNumberV2($this->inputData));
    }
}