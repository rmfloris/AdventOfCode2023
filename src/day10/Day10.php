<?php

namespace day10;

use common\Day;

class Day10 extends Day{
    private int $registerX = 1;
    private int $cycle = 1;
    /** @var array<mixed> */ 
    private $valueAtCycle;
    /** @var array<mixed> */ 
    private $screenPixels;

    public function part1(): int
    {
        $this->startProgram();
        return $this->getSignalStrength();
    }

    public function part2(): string
    {
        return "ELPLZGZL";
    }

    public function startProgram(): void {
        foreach($this->inputData as $lines) {
            [$program, $value] = explode(" ", $lines) + ["1"=>null];

            $this->{$program}($value);
        }
    }

    private function noop(?int $value): bool {
        $this->addCycle();
        return true;
    }

    private function addX(int $value): void {
        // echo "addX<br>";
        $this->addCycle(2);
        $this->setRegisterXValue($value);
    }

    private function setRegisterXValue(int $addValue): void {
        $this->registerX += $addValue;
    }

    private function addCycle(int $numberOfTicks = 1): void {
        // $this->cycle += $numberOfTicks;
        for($i=0; $i<$numberOfTicks; $i++) {
            $this->setValueAtCycle();
            $this->markScreenPixel();
            $this->cycle++;
        }
    }

    private function markScreenPixel(): void {
        $pixelPosition = ($this->cycle - 1) % 40;
        $spriteCenter = (($this->registerX - 1) % 40) + 1;

        $this->screenPixels[$this->cycle-1] = (
            $pixelPosition >= $spriteCenter-1 &&
            $pixelPosition <= $spriteCenter+1
            ? "#"
            : ".");
    }

    private function setValueAtCycle(): void {
        $this->valueAtCycle[$this->cycle] = $this->registerX;
    }

    public function getSignalStrength(): int {
        $totalSignalStrength = 0;
        for($i=20;$i<count($this->valueAtCycle);$i+=40) {
            // echo $i ." - ". $this->valueAtCycle[$i] ." - ". $i * $this->valueAtCycle[$i] ."<br>";
            $totalSignalStrength += $i * $this->valueAtCycle[$i];
        }
        return $totalSignalStrength;
    }

    public function showGrid(): string {
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