<?php

namespace day10;

use common\Day;

class Day10 extends Day{
    private $registerX = 1;
    private $cycle = 1;
    private $valueAtCycle = [];
    private $screenPixels = [];

    public function part1()
    {
        $this->startProgram();
        return $this->getSignalStrength();
    }

    public function part2()
    {
        return "ELPLZGZL";
    }

    public function startProgram() {
        foreach($this->inputData as $lines) {
            [$program, $value] = explode(" ", $lines) + ["1"=>null];

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

    private function markScreenPixel() {
        $pixelPosition = ($this->cycle - 1) % 40;
        $spriteCenter = (($this->registerX - 1) % 40) + 1;

        $this->screenPixels[$this->cycle-1] = (
            $pixelPosition >= $spriteCenter-1 &&
            $pixelPosition <= $spriteCenter+1
            ? "#"
            : ".");
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