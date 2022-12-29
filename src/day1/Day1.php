<?php
namespace day1;
use common\Day;

class Day1 extends Day {

    private $elves = array();
    private $elfDetail = array();

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
        $totalCalories = 0;
        $count = 0;

        foreach($sortedArray as $calories) {
            $totalCalories += $calories;
            $count++;
            if($count >= $number) {
                break;
            }
        }
        return $totalCalories;
    }

    public function showElves() {
        return $this->elves;
    }

    public function getCaloriesTop($numberOfPositions) {
        return $this->getTop($numberOfPositions);
    }

    public function showElvesDetails() {
        return $this->elfDetail;
    }

    public function getMostCaloriesWithSingleElf() {
        return max($this->elves);
    }

    public function getElfWithMostCalories() {
        return array_search(max($this->elves), $this->elves);
    }
}