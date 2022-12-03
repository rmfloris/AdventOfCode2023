<?php

namespace day3\utils;
use common\LoadInput;

class DuplicateFinder {

    private $inputData = array();
    private $rucksackContent = array();
    private $badges = array();
    private $duplicates = array();

    public function __construct($inputFile) {
        $this->inputData = $this->parseInput($inputFile);
    }

    private function parseInput($inputFile) {
        $data = explode("\n", (new LoadInput)->loadFile($inputFile));

        foreach($data as $rucksack) {

            $this->rucksackContent[] = array(
                substr($rucksack, 0, (strlen($rucksack)/2)),
                substr($rucksack, (strlen($rucksack)/2), strlen($rucksack))
            );
        }
        return $data;
    }

    public function getPriorityByBadge() {
        $this->findBadgeLetter();
        return $this->calculate($this->badges);
    }

    private function findBadgeLetter() {
        $i=0;
        while($i < count($this->inputData)-2) {
            $rucksack1 = str_split($this->inputData[$i]);
            $rucksack2 = str_split($this->inputData[$i+1]);
            $rucksack3 = str_split($this->inputData[$i+2]);

            foreach(array_unique($rucksack1) as $letter) {
                if(array_search($letter, $rucksack2) !== false && array_search($letter, $rucksack3) !== false) {
                    $this->badges[] = $letter;
                }
            }
            $i += 3;
        }
    }

    public function calculatePriorities() {
        $this->findDuplicateCharacters();
        return $this->calculate($this->duplicates);
    }

    private function calculate($duplicates) {
        $score = 0;
        foreach($duplicates as $duplicate) {
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