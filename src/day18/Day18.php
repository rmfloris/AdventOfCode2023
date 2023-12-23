<?php

namespace day18;

use common\Day;
use common\Helper;

class Day18 extends Day {
    private $map = [];
    private $moves = [];


    protected function loadData(): void
    {
        parent::loadData();
        foreach($this->inputData as $line) {
            preg_match_all("#(.*) (.*) \((.*)\)#", $line, $matches);
            $this->moves[] = [
                "direction" => $matches[1][0],
                "steps" => $matches[2][0],
                "color" => $matches[3][0]
            ];
        }
    }

    private function newPosition($direction) {
        return match($direction) {
            "R" => [1, 0],
            "L" => [-1, 0],
            "U" => [0, -1],
            "D" => [0, 1],
            default => [0, 0]
        };
    }

    private function startDrilling($x, $y) {
        $this->map[$y][$x] = "#";

        foreach($this->moves as $move) {
            $steps = $move["steps"];
            $direction = $move["direction"];

            for($i=0;$i<$steps;$i++) {
                [$xDirection, $yDirection] = $this->newPosition($direction);
                $x += $xDirection;
                $y += $yDirection;
                // echo "x: ". $x ." - y: ". $y ."<br>";
                $this->map[$y][$x] = "#";
            }
        }
    }

    private function fillupMap() {
        echo "fill up<br>";
        foreach($this->map as $y => $cells) {
            ksort($cells);
            $min = min(array_keys($cells));
            $max = max(array_keys($cells));
            $isInside = false;
            echo "min: ". $min ." - max: ". $max ."<br>";

            for($x=$min; $x<$max; $x++) {
                if(isset($this->map[$y][$x])) {
                    $isInside = !$isInside;
                    continue;
                }
                if($isInside) {
                    $this->map[$y][$x] = "#";
                } else {
                    $this->map[$y][$x] = ".";
                }
            }
            // print_r($cells);
        }
    }

    private function countHoles() {
        $count = 0;
        foreach($this->map as $line) {
            $count += array_count_values($line)["#"];
        }
        return $count;
    }

    public function getTableData():string {
        return Helper::showDataAsTable($this->map);
    }

    public function part1(): int {
        $this->startDrilling(0,0);
        $this->fillupMap();
        // print_r($this->map);
        return $this->countHoles();
    }

    public function part2(): int {
        return 1;
    }
    
}
