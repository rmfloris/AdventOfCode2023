<?php
namespace day1;
use common\Day;

class Day1 extends Day {

    private $elves = array();
    private $elfDetail = array();
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
                $this->elfDetail[$key][] = $calories;
            }
        }
    }

    private function getTop($number) {
        $sortedArray = $this->elves;
        arsort($sortedArray);

        return array_sum(array_slice($sortedArray,0,$number));
    }

    public function setNumberOfPositions(int $positions)
    {
        $this->numberOfPositions = $positions;
        return $this;
    }

    public function part1() {
        //getMostCaloriesWithSingleElf
        return max($this->elves);
    }

    public function part2() {
        //getCaloriesTop
        return $this->getTop($this->numberOfPositions);
    }
}