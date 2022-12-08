<?php

namespace day8\utils;

use common\LoadInput;

class Day8 {

    private $inputArray = [];

    public function __construct($filename) {
        $this->inputArray = $this->parseInput($filename);
    }

    private function parseInput($inputFile) {
        $data1 = explode("\n", (new LoadInput)->loadFile($inputFile));
        foreach($data1 as $key => $details) {
            foreach(str_split($details) as $cell) {
                $data[$key][] = $cell;
            }
        }
        return $data;
    }

    public function calculateVisibleTrees() {
        $number = 0;
        $number += $this->treesOnEdges();
        $number += $this->treesOnInside();
        return $number;
    }

    private function treesOnEdges() {
        return count($this->inputArray)*2 + count($this->inputArray[0])*2 - 4;
    }

    private function treesOnInside() {
        $number = 0;

        for($x=1; $x<count($this->inputArray)-1;$x++) {
            /**
             * x = row
             * y = columns
             */
            // $rowData = str_split($this->inputArray[$x]);
            for($y=1; $y<count($this->inputArray[$x])-1;$y++) {
                // echo "number: ". $this->inputArray[$x][$y] ."<br>";
                // echo "Visible: ". $this->isVisibleHorizontally($x, $y) ." - ". $this->isVisibileVertically($x, $y) ."<br>";
                // echo $this->isVisibileVertically($x, $y) ."<br>";
                $number += ($this->isVisibleHorizontally($x, $y) || $this->isVisibileVertically($x, $y) ? 1 : 0);
                // $number += ($this->isVisibleHorizontally($x, $y) ? 1 : 0);
                
            }
        }
        return $number;
    }

    private function isVisibleHorizontally($row, $column) {
         $rowData = $this->inputArray[$row];
         $maxTreesOnLeft = max(array_slice($rowData,0,$column));
         $maxTreesOnRight = max(array_slice($rowData,$column+1));
        //  echo "value: ". $this->inputArray[$row][$column] ." - Left: ". $maxTreesOnLeft . " - right: ". $maxTreesOnRight ."<br>";
         return ($this->inputArray[$row][$column] > $maxTreesOnLeft || $this->inputArray[$row][$column] > $maxTreesOnRight);
    }

    private function isVisibileVertically($row, $column) {
        $columnData = array_column($this->inputArray, $column);
        
        $maxTreesOnTop = max(array_slice($columnData,0,$row));
        $maxTreesOnBottom = max(array_slice($columnData,$row+1));
        return ($this->inputArray[$row][$column] > $maxTreesOnTop || $this->inputArray[$row][$column] > $maxTreesOnBottom);
    }
}