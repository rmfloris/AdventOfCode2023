<?php

namespace day10\utils;
use common\LoadInput;

class Day10 {
    private $inputArray = [];
    private $registerX = 1;
    private $cycle = 1;
    private $valueAtCycle = [];
    private $screenPixels = [];
    private $spriteLocation = [1,2,3];

    public function __construct($filename) {
        $this->inputArray = $this->parseInput($filename);
    }

    private function parseInput($inputFile) {
        return explode("\n", (new LoadInput)->loadFile($inputFile));
    }

    public function startProgram() {
        foreach($this->inputArray as $lines) {
            [$program, $value] = explode(" ", $lines) + ["1"=>null];

            // echo "Program: ". $program ." - value: ". $value ."<br>";
            $this->{$program}($value);
        }
    }

    private function noop($value) {
        $this->addCycle();
        return true;
    }

    private function addX($value) {
        // echo "addX<br>";
        $this->addCycle(2);
        $this->setRegisterXValue($value);
    }

    private function setRegisterXValue($addValue) {
        $this->registerX += $addValue;
        $this->updateSpriteLocation();
        return true;
    }
    
    private function addCycle($numberOfTicks = 1) {
        // $this->cycle += $numberOfTicks;
        for($i=0; $i<$numberOfTicks; $i++) {
            $this->setValueAtCycle();
            $this->markScreenPixel();
            $this->cycle++;
        }
        return true;
    }

    private function updateSpriteLocation(){
        $row = floor($this->cycle/40) * 40;
        // echo "row: ". $row ."<br>";
        $this->spriteLocation = range($this->registerX+$row, $this->registerX+$row+2);
        
    }

    private function markScreenPixel() {
        $this->screenPixels[$this->cycle-1] = (in_array($this->cycle, $this->spriteLocation) ? "#" : ".");
        // echo "draws at postion ". $this->cycle-1 ."<br>";
        // echo "sprite location: ". implode("", $this->spriteLocation) ."<br>";
        // echo "Current CRT row: ". implode("", $this->screenPixels) ."<br>";
    }

    private function setValueAtCycle() {
        $this->valueAtCycle[$this->cycle] = $this->registerX;
        return true;
    }

    public function getSignalStrength() {
        $totalSignalStrength = 0;
        for($i=20;$i<count($this->valueAtCycle);$i+=40) {
            // echo $i ." - ". $this->valueAtCycle[$i] ." - ". $i * $this->valueAtCycle[$i] ."<br>";
            $totalSignalStrength += $i * $this->valueAtCycle[$i];
        }
        return $totalSignalStrength;
    }

    public function showGrid() {
        $table = "<table>";

        for($y=0;$y<240;$y+=40) {
            $table .= "<tr>";
            for($x=0; $x<40; $x++) {
                $table .= "<td>". $this->screenPixels[$y+$x] ."</td>";
            }
            $table .= "</tr>";
        }
        return $table;
    }
}