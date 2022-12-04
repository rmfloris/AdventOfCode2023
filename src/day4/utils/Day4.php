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

            if($this->checkFullOverlap($firstElf[0], $firstElf[1], $secondElf[0], $secondElf[1]) || 
            $this->checkFullOverlap($secondElf[0], $secondElf[1], $firstElf[0], $firstElf[1])) {
                $number += 1;
            }
        }
        return $number;
    }

    public function findNumberOfPartylOverlappingRange() {
        $number = 0;
        foreach($this->pairContent as $data) {
            $firstElf = explode("-", $data[0]);
            $secondElf = explode("-", $data[1]);

            if($this->checkPartlyOverlap($firstElf[0], $firstElf[1], $secondElf[0], $secondElf[1])) {
                // echo $firstElf[0] ." - ". $firstElf[1] ." - ". $secondElf[0] ." - ". $secondElf[1] ." - ". $this->checkPartlyOverlap($firstElf[0], $firstElf[1], $secondElf[0], $secondElf[1]) ."<br>";
                $number += 1;
            }
        }
        return $number;
    }

    private function checkFullOverlap($start1, $end1, $start2, $end2) {
        if($start1 <= $start2 && $end1 >= $end2) { return true; }
        return false;
    }

    private function checkpartlyOverlap($firstStart, $firstEnd, $secondStart, $secondEnd) {
        return in_array($firstStart, range($secondStart, $secondEnd)) || 
        in_array($firstEnd, range($secondStart, $secondEnd)) || 
        in_array($secondStart, range($firstStart, $firstEnd)) || 
        in_array($secondEnd, range($firstStart, $firstEnd));
    }
}