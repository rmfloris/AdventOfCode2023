<?php

namespace day15;

use common\Day;

class Day15 extends Day {
    /** @var array<mixed> */
    private $stringToCalculate = [];
    /** @var array<mixed> */
    private $boxes = [];

    protected function loadData(): void
    {
        parent::loadData();
        foreach($this->inputData as $line) {
            $this->stringToCalculate = explode(",", $line);
        }
    }   

    private function getHasNumber(string $char): int {
        return ord($char);
    }

    private function calculateHash(string $string): int {
        $currentValue = 0;
        foreach(str_split($string) as $char) {
            $currentValue += $this->getHasNumber($char);
            $currentValue = ($currentValue * 17) % 256;
            // echo "- ". $char ." - ". $currentValue ."<br>";
        }
        return $currentValue;
    }

    /**
     * @return array<mixed>
     */
    private function getDetails(string $string) {
        preg_match('/^(.+)([=-])(.*)$/',$string, $matches);
        return [$matches[1], $matches[2], $matches[3]];
    }

    private function updateBoxes(string $string): void {
        [$label, $operator, $lens] = $this->getDetails($string);
        $labelValue = $this->calculateHash($label);
        if($operator === "-") {
            unset($this->boxes[$labelValue][$label]);
            return;
        }
        $this->boxes[$labelValue][$label] = $lens;
    }

    private function calcFocusPower(): int {
        $totalValue = 0;
        foreach($this->boxes as $boxNo => $box) {
            if(empty($box)) {
                continue;
            }
            $position = 0;
            foreach($box as $lens) {
                $totalValue += ($boxNo+1) * ++$position * $lens;
            }
        }
        return $totalValue;
    }


    public function part1(): int {
        $totalValue = 0;
        foreach($this->stringToCalculate as $string) {
            $totalValue += $this->calculateHash($string);
        }
        return $totalValue;
    }

    public function part2(): int {
        foreach($this->stringToCalculate as $string) {
            $this->updateBoxes($string);
        }
        return $this->calcFocusPower();
    }
    
}
