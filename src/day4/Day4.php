<?php
namespace day4;

use common\Day;

class Day4 extends Day {
    /** @var array<mixed> */
    private array $pairContent;

    protected function LoadData():void
    {
        parent::loadData();
        $this->generatePairData();
    }

    public function part1(): int
    {
        return $this->findNumberOfFullyOverlappingRange();
    }

    public function part2(): int
    {
        return $this->findNumberOfPartylOverlappingRange();
    }

    private function generatePairData(): void {
        foreach($this->inputData as $pair) {
            $dataPerPair = explode(",", $pair);

            $this->pairContent[] = array(
                $dataPerPair[0],
                $dataPerPair[1]
            );
        }
    }

    public function findNumberOfFullyOverlappingRange(): int {
        $number = 0;
        foreach($this->pairContent as $data) {
            $firstElf = explode("-", $data[0]);
            $secondElf = explode("-", $data[1]);

            if($this->checkFullOverlap($firstElf[0], $firstElf[1], $secondElf[0], $secondElf[1]) || 
            $this->checkFullOverlap($secondElf[0], $secondElf[1], $firstElf[0], $firstElf[1])) {
                $number += 1;
            }
        }
        return $number;
    }

    public function findNumberOfPartylOverlappingRange(): int {
        $number = 0;
        foreach($this->pairContent as $data) {
            $firstElf = explode("-", $data[0]);
            $secondElf = explode("-", $data[1]);

            if($this->checkPartlyOverlap($firstElf[0], $firstElf[1], $secondElf[0], $secondElf[1])) {
                $number += 1;
            }
        }
        return $number;
    }

    private function checkFullOverlap(string $start1, string $end1, string $start2, string $end2): bool {
        if($start1 <= $start2 && $end1 >= $end2) { return true; }
        return false;
    }

    private function checkpartlyOverlap(string $firstStart, string $firstEnd, string $secondStart, string $secondEnd): bool {
        return in_array($firstStart, range($secondStart, $secondEnd)) || 
        in_array($firstEnd, range($secondStart, $secondEnd)) || 
        in_array($secondStart, range($firstStart, $firstEnd)) || 
        in_array($secondEnd, range($firstStart, $firstEnd));
    }
}