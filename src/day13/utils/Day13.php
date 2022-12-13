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
            if(strlen($line > 0)) {
                // echo "lineimport: ". print_r(json_decode($line),true) ."<br>";
                $this->inputData[] = json_decode($line);
            }
        }
    }

    public function startComparing() {
        $pair = 1;
        for($i=0; $i<count($this->inputData);$i++) {
            // echo "<p>== Pair ". $pair ." ==<br>";
            $this->pairs[$pair] = $this->compareLines($this->inputData[$i], $this->inputData[$i+1]);

            $i++;
            $pair++;
        }
        return $this->pairs;
    }

    public function getSumOfIndices() {
        return array_sum(array_keys(array_filter($this->pairs, function($v, $k) {
            return $v > 0;
        }, ARRAY_FILTER_USE_BOTH)));
    }

    public function getPairs() {
        return $this->pairs;
    }

    private function compareLines($line1, $line2) {
        $status = 1;

        // echo "line 1: ". print_r($line1, true) ."<br>";
        // echo "line 2: ". print_r($line2, true) ."<br>";
        // echo "- Compare [". implode(",", $line1) ."] vs [". implode(",", $line2) ."]<br>";
        for($i=0; $i<count($line1);$i++) {
            // mixed types
            //
            // echo "Line: ". print_r($line1, true) ."<br>";
            if(getType($line1[$i]) != gettype($line2[$i])) {
                // echo "type different<br>";
                $status = $this->convertToArrayAndCompare($line1[$i], $line2[$i]);
                if($status != -1) return $status;
            }
            // compare pairs
            //
            $status = $this->comparePair($line1[$i], $line2[$i]);
            if($status != -1) return $status;
        }
        if($this->compareArrayLength($i, $line1, $line2) != -1) { return $this->compareArrayLength($i, $line1, $line2); }
        return $status;
    }

    private function convertToArrayAndCompare($line1, $line2) {
        if(is_null($line2)) { return 0; }
        (is_array($line1) ? $line2 = [$line2] : $line1 = [$line1]);
        return $this->compareLines($line1, $line2);
    }

    private function compareArrayLength($position, $array1, $array2) {
        return (count(array_slice($array1, $position)) == 0 && count(array_slice($array2, $position)) > 0 ? 1: 0);
    }

    private function comparePair($pair1, $pair2) {
        // echo "  - Compare ". $pair1 ." vs ". $pair2 ."<br>";
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