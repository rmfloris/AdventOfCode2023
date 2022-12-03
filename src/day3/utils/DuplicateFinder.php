<?php

namespace day3\utils;
use common\LoadInput;

class DuplicateFinder {

    private $inputData = array();
    private $rucksackContent = array();

    public function __construct($inputFile) {
        $this->inputData = $this->parseInput($inputFile);
    }

    private function parseInput($inputFile) {
        $this->inputData = explode("\n", (new LoadInput)->loadFile($inputFile));

        foreach($this->inputData as $rucksack) {

            $this->rucksackContent[] = array(
                substr($rucksack, 0, (strlen($rucksack)/2)),
                substr($rucksack, (strlen($rucksack)/2), strlen($rucksack))
            );
        }
    }

    public function calculatePriorities() {
        return $this->calculate($this->findDuplicateCharacters());
    }

    private function calculate($listOfDuplicates) {
        $score = 0;
        foreach($listOfDuplicates as $letter) {
            $score += $this->letterToPoints($letter);
        }
        return $score;
    }

    private function letterToPoints($letter) {
        $listOfPoints = array_merge(range('a', 'z'), range('A', 'Z'));

        return array_search($letter, $listOfPoints)+1;
    }

    private function findDuplicateCharacters() {
        $duplicates = [];
        foreach($this->rucksackContent as $key => $compartments) {
            $compartment1 = str_split($compartments[0]);
            $compartment2 = str_split($compartments[1]);
            // print_r($compartments);
            foreach(array_unique($compartment1) as $content) {
                // echo $content ." - ". strpos($compartments[1], $content) ."<br>";
                if(array_search($content, $compartment2)) {
                    $duplicates[] = $content;
                }
            }
        }
        return $duplicates;
    }
}