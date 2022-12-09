<?php

namespace day9\utils;
use common\LoadInput;

class Day9 {
    private $inputArray = [];
    private $currentLocations = [];
    private $visitedLocations = [];

    public function __construct($filename) {
        $this->inputArray = $this->parseInput($filename);
        $this->currentLocations = array_fill(0,10,["x"=>0, "y"=>0]);
    }

    private function parseInput($inputFile) {
        return explode("\n", (new LoadInput)->loadFile($inputFile));
    }

    public function startMoving() {
        foreach($this->inputArray as $moveDetail) {
            [$direction, $steps] = explode(" ", $moveDetail);
            $this->makeMoveHead($direction, $steps);
        }
    }

    private function makeMoveHead($direction, $steps) {
        for($i=0; $i<$steps;$i++) {
            [$x, $y] = $this->calculateStep($direction);
            $this->currentLocations[0]["x"] += $x;
            $this->currentLocations[0]["y"] += $y;

            for($y=1; $y<count($this->currentLocations);$y++) {
                $this->checkNextKnotTouching($y-1);
            }
        }
    }

    private function checkNextKnotTouching ($prevKnotIndex) {
        $currentKnotIndex = $prevKnotIndex+1;
        ["x" => $xPrev, "y" => $yPrev] = $this->currentLocations[$prevKnotIndex];
        ["x" => $xCurrent, "y" => $yCurrent] = $this->currentLocations[$currentKnotIndex];
        if(abs($xPrev - $xCurrent) <= 1 && abs($yPrev - $yCurrent) <= 1) {
            $this->setVisitedLocations($currentKnotIndex, $xCurrent, $yCurrent);
            return false;
        }
        if(abs($xPrev - $xCurrent) > 1 && abs($yPrev - $yCurrent) == 0) {
            // delta alleen op x
            $direction = ($xPrev - $xCurrent > 0 ? "R" : "L");
        }
        if(abs($xPrev - $xCurrent) == 0 && abs($yPrev - $yCurrent) > 1) {
            // delta alleen op y
            $direction = ($yPrev - $yCurrent > 0 ? "U" : "D");
        }
        if(
            abs($yPrev - $yCurrent) > 1 && abs($xPrev - $xCurrent) >= 1 ||
            abs($xPrev - $xCurrent) > 1 && abs($yPrev - $yCurrent) >= 1
            ) {
            // diagonaal 1
            $direction = "";
            $direction .= ($xPrev - $xCurrent > 0 ? "R" : "L");
            $direction .= ($yPrev - $yCurrent > 0 ? "U" : "D");
        }
        [$x, $y] = $this->calculateStep($direction);
        $this->currentLocations[$currentKnotIndex]["x"] += $x;
        $this->currentLocations[$currentKnotIndex]["y"] += $y;
        $this->setVisitedLocations($currentKnotIndex, $xCurrent+$x, $yCurrent+$y);
    }

    private function calculateStep($direction) {
        $xValue = 0;
        $yValue = 0;

        switch($direction) {
            case "R":
                $xValue = 1;
                break;
            case "U":
                $yValue = 1;
                break;
            case "L":
                $xValue = -1;
                break;
            case "D":
                $yValue = -1;
                break;
            case "RU":
                $xValue = 1;
                $yValue = 1;
                break;
            case "RD":
                $xValue = 1;
                $yValue = -1;
                break;
            case "LU":
                $xValue = -1;
                $yValue = 1;
                break;
            case "LD":
                $xValue = -1;
                $yValue = -1;
                break;
            }
        return [$xValue, $yValue];
    }
    
    private function setVisitedLocations($knotIndex, $x, $y) {
        $this->visitedLocations[$knotIndex][$x."-".$y] = "1";
    }

    public function getNumberOfPositions($knotIndex) {
        return count($this->visitedLocations[$knotIndex]);
    }
}