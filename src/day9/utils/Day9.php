<?php
namespace day9\utils;

use common\LoadInput;
use LDAP\Result;

class Day9 {
    private $inputArray = [];
    private $tailLocations = [];
    private $currentLocationHead = ["x"=>1, "y"=>1];
    private $currentLocationTail = ["x"=>1, "y"=>1];

    public function __construct($filename) {
        $this->inputArray = $this->parseInput($filename);
    }

    private function parseInput($inputFile) {
        $data = explode("\n", (new LoadInput)->loadFile($inputFile));
        return $data;
    }

    public function startMoving() {
        $this->setTailLocation($this->currentLocationHead["x"], $this->currentLocationHead["y"]);
        foreach($this->inputArray as $moveDetail) {
            $move = explode(" ", $moveDetail);
            $this->makeMoveHead($move[0], $move[1]);
        }
    }

    private function makeMoveHead($direction, $steps) {
        ['x' => $x, 'y' => $y] = $this->currentLocationHead;
        // echo "Start Head -> x: ". $x ." - y: ". $y ."<br>";
        // echo "Start Tail -> x: ". $this->currentLocationTail["x"] ." - y: ". $this->currentLocationTail["y"] ."<br>";

        for($i=0; $i<$steps;$i++) {
            $this->currentLocationHead = [
                "x" => $this->calculateNewValuePosition("x", "head", $direction), 
                "y" => $this->calculateNewValuePosition("y", "head", $direction)
            ];
            // echo "Direction: ". $direction ." x: ". $this->currentLocationHead["x"] ." - y: ". $this->currentLocationHead["y"] ."<br>";
            $this->checkTailTouching();
            
        }        
    }

    private function makeMoveTail($direction, $steps) {
        ['x' => $x, 'y' => $y] = $this->currentLocationTail;
        // echo "Start Tail-> x: ". $x ." - y: ". $y ."<br>";
        for($i=0; $i<$steps;$i++) {
            $x =$this->calculateNewValuePosition("x", "tail", $direction);
            $y =$this->calculateNewValuePosition("y", "tail", $direction);
            
            $this->currentLocationTail = [
                "x" => $x, 
                "y" => $y
            ];
            $this->setTailLocation($x, $y);

            // echo "Direction Tail: ". $direction ." x: ". $this->currentLocationTail["x"] ." - y: ". $this->currentLocationTail["y"] ."<br>";
        }        
    }

    private function checkTailTouching() {
        ['x' => $xTail, 'y' => $yTail] = $this->currentLocationTail;
        ['x' => $xHead, 'y' => $yHead] = $this->currentLocationHead;

        if(abs($xHead - $xTail) <= 1 && abs($yHead - $yTail) <= 1) {
            // still touching
            return false;
        }
        if(abs($xHead - $xTail) > 1 && abs($yHead - $yTail) == 0) {
            // delta alleen op x
            $direction = ($xHead - $xTail > 0 ? "R" : "L");
            $this->makeMoveTail($direction, 1);
        }
        if(abs($yHead - $yTail) > 1 && abs($xHead - $xTail) == 0) {
            // delta alleen op y
            $direction = ($yHead - $yTail > 0 ? "U" : "D");
            $this->makeMoveTail($direction, 1);
        }        
        if(
            abs($yHead - $yTail) > 1 && abs($xHead - $xTail) == 1 ||
            abs($xHead - $xTail) > 1 && abs($yHead - $yTail) == 1
            ) {
            // diagonaal 1
            $direction = "";
            $direction .= ($xHead - $xTail > 0 ? "R" : "L");
            $direction .= ($yHead - $yTail > 0 ? "U" : "D");
            $this->makeMoveTail($direction, 1);
        }
    }

    private function calculateNewValuePosition($axis, $who, $direction) {
        if ($who == "head") {
            ['x' => $x, 'y' => $y] = $this->currentLocationHead;
        }
        if ($who == "tail") {
            ['x' => $x, 'y' => $y] = $this->currentLocationTail;
        }
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

        if($axis == "x") { return $x + $xValue;}
        if($axis == "y") { return $y + $yValue;}
        return 0;
    }

    private function setTailLocation($x, $y) {
        $this->tailLocations[$x."-".$y] = "1";
    }

    public function getNumberOfPositions() {
        return count($this->tailLocations);
    }
}