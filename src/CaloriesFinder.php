<?php

class CaloriesFinder {

    private $inputData = array();
    private $elves = array();
    private $elfDetail = array();

    public function __construct($input) {
        $this->inputData = $this->parseInput($input);
    }

    private function parseInput($input){
        $this->inputData = explode("\n", $this->loadFile($input));
        
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

    private function loadFile($filename) {
        $file = fopen($filename, "r") or die("Unable to open file!");
        $data = fread($file,filesize($filename));
        fclose($file);

        return $data;
    }
}