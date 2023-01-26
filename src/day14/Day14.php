<?php

namespace day14;

use common\Day;

class Day14 extends Day{

    /** @var array<mixed> */
    private array $graph;
    /** @var array<mixed> */
    private array $borders = array(
        "minX" => "500",
        "maxX" => "500",
        "minY" => "0",
        "maxY" => "0"
    );
    private int $score = 0;
    private int $part = 1;

    protected function loadData(): void
    {
        parent::loadData();
        $this->parseData();
    }

    public function part1(): int
    {
        return $this->dropSandUnits();
    }

    public function part2(): int
    {
        $this->setPart(2);
        return $this->dropSandUnits();
    }

    public function setPart(int $part): void {
        $this->part = $part;
        if ($part == 2) {
            $this->setFloor();
        }
    }

    private function setFloor(): void {
        /**
         * minX - maxX for maxY+2
         */
        $this->borders["maxY"] += 2;
        $this->borders["minX"] -= 2;
        $this->borders["maxX"] += 2;

        for($i=$this->borders["minX"];$i<=$this->borders["maxX"];$i++) {
                $this->graph[$this->getKey($i, $this->borders["maxY"])] = "#";
        }
    }

    // public function dropSandUnits(int $numberOfUnits) {
    //     while($this->dropSand() && $numberOfUnits > 0) {
    //         $numberOfUnits--;
    //     }
    //     return $this->score;
    // }

    public function dropSandUnits(): int {
        while($this->dropSand()) {
        }
        return $this->score;
    }

    private function dropSand(): bool {
        $sandX = 500;
        $sandY = 0;

        while(1) {
            $downKey = $this->getKey($sandX, $sandY+1);
            $leftKey = $this->getKey($sandX-1, $sandY+1);
            $rightKey = $this->getKey($sandX+1, $sandY+1);

            if($this->part == 2) {
                if($sandY+1 >= $this->borders["maxY"]) {
                    // echo "sandX-1: ". $sandX-1 ."<br>";
                    // echo "sandX+1: ". $sandX+1 ."<br>";

                    $this->graph[$this->getKey($sandX-1, $sandY+1)] = "#";
                    $this->setMinMax($sandX-1, $sandY+1);
                    $this->graph[$this->getKey($sandX+1, $sandY+1)] = "#";
                    $this->setMinMax($sandX+1, $sandY+1);
                }
            }

            if(
                $sandX-1 < $this->borders["minX"] ||
                $sandX+1 > $this->borders["maxX"]
            ) {
                // echo "out of borders<br>";
                return false;
            }

            $down = isset($this->graph[$downKey]) ? $this->graph[$downKey] : ".";
            $leftDown = isset($this->graph[$leftKey]) ? $this->graph[$leftKey] : ".";
            $rightDown = isset($this->graph[$rightKey]) ? $this->graph[$rightKey] : ".";

            if($down == "o" && $leftDown == "o"  && $rightDown == "o" && $sandY == 0) {
                $this->graph[$this->getKey($sandX, $sandY)] = "o";
                $this->score++;
                // echo "X: ". $sandX ."<br>";
                // echo "Y: ". $sandY ."<br>";
                // echo "can't move<br>";
                return false;
            }

            if($down != "." && $leftDown != "." && $rightDown != ".") {
                $this->graph[$this->getKey($sandX, $sandY)] = "o";
                $this->score++;
                return true;
            }

            // down
            if($down == ".") {
                $sandY++;
            } else {
                if($leftDown == ".") {
                    $sandX--;
                    $sandY++;
                } elseif ($rightDown == ".") {
                    $sandX++;
                    $sandY++;
                }
            }
            /**
             * over left min or right min -> stop
             */
        }
    }

    private function parseData(): void
    {
        foreach($this->inputData as $line) {
            $positions = explode(" -> ", $line);

            list($startX, $startY) = explode(",", $positions[0]);
            $this->setMinMax($startX, $startY);
            for($i=1; $i<count($positions); $i++) {
                list($x, $y) = explode(",", $positions[$i]);
                $this->setMinMax($x, $y);

                if($x == $startX) {
                    $direction = ($y > $startY ? 1 : -1);
                    for($j=$startY;$j!=$y;$j=$j+$direction){
                        $this->graph[$this->getKey($startX, $j)] = "#";
                    }
                }

                if($y == $startY) {
                    $direction = ($x > $startX ? 1 : -1);
                    for($j=$startX;$j!=$x;$j=$j+$direction){
                        $this->graph[$this->getKey($j, $startY)] = "#";
                    }
                }

                $this->graph[$this->getKey($x, $y)] = "#";

                $startX = $x;
                $startY = $y;
            }
        }
    }

    private function setMinMax(string|int $x, string|int $y): void {
        if($x < $this->borders["minX"]) { $this->borders["minX"] = $x; }
        if($x > $this->borders["maxX"]) { $this->borders["maxX"] = $x; }
        if($y < $this->borders["minY"]) { $this->borders["minY"] = $y; }
        if($y > $this->borders["maxY"]) { $this->borders["maxY"] = $y; }
    }

    public function printGraph(): string {
        $table = "<table>";
        $table .= "<tr><th>";
        foreach(range($this->borders["minX"], $this->borders["maxX"]) as $header) {
            $table .= "<td>". $header ."</td>";
        }
        $table .= "</th></tr>";

        for($y = $this->borders["minY"]; $y <= $this->borders["maxY"]; $y++) {
            $table .= "<tr>";
            $table .= "<td>". $y ."</td>";
            for($x = $this->borders["minX"]; $x <= $this->borders["maxX"]; $x++) {
                $value = $this->graph[$this->getKey($x, $y)] ?? ".";
                $table .= "<td>". $value ."</td>";
            }
        }
        return $table;
    }

    private function getKey(string|int $x, string|int $y): string {
        return json_encode([(string)$x, (string)$y]);
    }
}