<?php

namespace day13\utils;
use common\LoadInput;

class Day13 {

    private array $inputData;
    private array $pairs;

    public function __construct($filename) {
        $this->parseData($filename);
    }

    private function parseData($filename) {
        $lines = (new LoadInput)->loadFileToLines($filename);
        foreach($lines as $line) {
            if(json_decode($line) == null) {
                continue;
            } else {
                $this->inputData[] = json_decode($line);
            }
        }
    }

    public function startComparing() {
        $pair = 1;
        for($i=0; $i<count($this->inputData);$i++) {
            $this->pairs[$pair] = $this->compareLines($this->inputData[$i], $this->inputData[$i+1]);
            $i++;
            $pair++;
        }
        return $this->pairs;
    }

    private function compareLines($line1, $line2) {
        $status = 1;

        // echo "line 1: ". print_r($line1, true) ."<br>";
        // echo "line 2: ". print_r($line2, true) ."<br>";
        for($i=0; $i<count($line1);$i++) {
            if(getType($line1[$i]) != gettype($line2[$i])) {
                $status = $this->convertToArrayAndCompare($line1[$i], $line2[$i]);
                if($status != -1) return $status;
            }
            $status = $this->comparePair($line1[$i], $line2[$i]);
            if($status != -1) return $status;
        }
        return $status;
    }

    private function convertToArrayAndCompare($line1, $line2) {
        (is_array($line1) ? $line2 = [$line2] : $line1 = [$line1]);
        return $this->compareLines($line1, $line2);
    }

    private function comparePair($pair1, $pair2) {
        if($pair1 == $pair2) return -1;
        if($pair1 < $pair2) return 1;
        return 0;
    }


    /**
     * 
     */

/*
    public function comparePackets() {
        $pair = 1;
        for($i=0; $i<count($this->inputData);$i++) {

            $rightOrder = $this->inOrderPair(($this->inputData[$i]), $this->inputData[$i+1]);
            $this->pairs[$pair] = $rightOrder;
            $i++;
            $pair++;
        }
        return $this->pairs;
    }

    private function inOrderPair($pair1, $pair2) {
        $inOrder = 1;
        if(gettype($pair1) != gettype($pair2)) {
            (is_array($pair1) ? $pair2 = json_decode($pair2) : $pair1 = json_decode($pair1));
        }

        if(count($pair1) < count($pair2)) { echo "array smaller<br>"; return $inOrder; }
        for($i=0; $i<count($pair1); $i++) {
            echo "compare ". $pair1[$i] ." vs ". $pair2[$i] ."<br>";
            if($pair1[$i] > $pair2[$i]) {
                $inOrder = 0;
            }
        }
        return $inOrder;
    }
    */
}