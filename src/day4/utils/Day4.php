<?php

namespace day4\utils;
use common\LoadInput;

class Day4 {

    private $inputData = array();
    private $dataPerPair = array();

    public function __construct($inputFile) {
        $this->inputData = $this->parseInput($inputFile);
    }

    private function parseInput($inputFile) {
        $data = explode("\n", (new LoadInput)->loadFile($inputFile));

        foreach($data as $pair) {
            $dataPerPair = explode(",", $pair);

            $this->pairContent[] = array(
                $dataPerPair[0],
                $dataPerPair[1]
            );
        }
        return $data;
    }

    public function findNumberOfFullyOverlappingRange() {
        $number = 0;
        foreach($this->pairContent as $data) {
            $firstElf = explode("-", $data[0]);
            $secondElf = explode("-", $data[1]);

            if($this->checkOverlap($firstElf[0], $firstElf[1], $secondElf[0], $secondElf[1]) || 
            $this->checkOverlap($secondElf[0], $secondElf[1], $firstElf[0], $firstElf[1])) {
                $number += 1;
            }
        }
        return $number;
    }

    private function checkOverlap($start1, $end1, $start2, $end2) {
        if($start1 <= $start2 && $end1 >= $end2) { return true; }
        return false;
    }
}