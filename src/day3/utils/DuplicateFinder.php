<?php

namespace day3\utils;
use common\LoadInput;

class DuplicateFinder {

    private $inputData = array();
    private $rucksackContent = array();
    private $duplicates = array();

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
        $this->findDuplicateCharacters();
        return $this->calculate();
    }

    private function calculate() {
        $score = 0;
        foreach($this->duplicates as $key => $duplicate) {
            $score += $this->letterToPoints($duplicate);
            // $this->duplicates[$key]["score"] = $this->letterToPoints($duplicate["letter"]);
        }
        return $score;
    }

    public function showDuplicates() {
        return $this->duplicates;
    }

    private function letterToPoints($letter) {
        $listOfPoints = array_merge(range('a', 'z'), range('A', 'Z'));

        return array_search($letter, $listOfPoints)+1;
    }

    private function findDuplicateCharacters() {
        foreach($this->rucksackContent as $key => $compartments) {
            $compartment1 = str_split($compartments[0]);
            $compartment2 = str_split($compartments[1]);
            foreach(array_unique($compartment1) as $content) {
                if(array_search($content, $compartment2) !== false) {
                    $this->duplicates[] = $content;
                }
            }
        }
    }
}