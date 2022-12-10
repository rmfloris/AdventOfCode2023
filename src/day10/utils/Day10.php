<?php

namespace day10\utils;
use common\LoadInput;

class Day10 {
    private $inputArray = [];
    private $registerX = 1;
    private $cycle = 1;
    private $valueAtCycle = [];

    public function __construct($filename) {
        $this->inputArray = $this->parseInput($filename);
        // $this->valueAtCycle[$this->cycle] = $this->registerX;
    }

    private function parseInput($inputFile) {
        return explode("\n", (new LoadInput)->loadFile($inputFile));
    }

    public function startProgram() {
        foreach($this->inputArray as $lines) {
            [$program, $value] = explode(" ", $lines) + ["1"=>null];

            // echo "Program: ". $program ."<br>";
            $this->{$program}($value);
        }
    }

    private function noop($value) {
        // echo "noop<br>";
        $this->addCycle();
        return true;
    }

    private function addX($value) {
        // echo "addX<br>";
        $this->addCycle(2);
        $this->setRegisterXValue($value);
    }

    private function setRegisterXValue($addValue) {
        return $this->registerX += $addValue;
    }
    private function addCycle($numberOfTicks = 1) {
        // $this->cycle += $numberOfTicks;
        for($i=0; $i<$numberOfTicks; $i++) {
            $this->setValueAtCycle();
            $this->cycle++;            
        }
        return true;
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
}