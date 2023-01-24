<?php
namespace day1;
use common\Day;

class Day1 extends Day {

    /** @var array<mixed> */
    private array $elves = [];
    private int $numberOfPositions = 1;

    protected function loadData(): void
    {
        parent::loadData();
        $key = 0;
        foreach($this->inputData as $calories) {
            if($calories == "") {
                $key++;
            } else {
                (isset($this->elves[$key]) ? $this->elves[$key] += $calories: $this->elves[$key] = $calories);
            }
        }
    }

    private function getTop(int $number): int {
        $sortedArray = $this->elves;
        arsort($sortedArray);

        return array_sum(array_slice($sortedArray,0,$number));
    }

    public function setNumberOfPositions(int $positions): void
    {
        $this->numberOfPositions = $positions;
    }

    public function part1(): int {
        return max($this->elves);
    }

    public function part2(): int {
        $this->setNumberOfPositions(3);
        return $this->getTop($this->numberOfPositions);
    }
}