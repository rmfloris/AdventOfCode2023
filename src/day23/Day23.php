<?php

namespace day23;

use common\Day;
use common\Helper;

class Day23 extends Day {
    private array $moveDirection = ["N", "S", "W", "E"];
    // private array $elfsLocations; // contains X-Y coords
    private array $elfsLocations1; // contains X-Y coords

    protected function loadData(): void {
        parent::LoadData();
        foreach($this->inputData as $y => $line) {
            foreach(str_split($line) as $x => $value) {
                if($value == "#") {
                    // $this->elfsLocations[]= [
                    //     "x" => $x,
                    //     "y" => $y
                    // ];
                    $this->elfsLocations1[Helper::getKey($x, $y)] = [
                        "x" => $x,
                        "y" => $y
                    ];
                }
            }
        }
    }

    public function startRounds($numberOfRounds = 1) {
        for($i=1; $i<=$numberOfRounds; $i++) {
            echo "round #". $i ."<br>";
            $proposals = $this->findMoves();
            print_r($proposals);
            $proposals = $this->checkProposals($proposals);
            print_r($proposals);
            $this->performProposals($proposals);

            $this->updateMoveOptions();
        }
    }

    private function checkProposals(array $proposals):array
    {
        foreach($proposals as $coords) {
            $keys = array_keys($proposals, $coords);
            if(count($keys) >1) {
                foreach($keys as $key) {
                    unset($proposals[$key]);
                }
                continue;
            }
        }
        return $proposals;
    }

    private function performProposals($proposals) :void
    {
        foreach($proposals as $elf => $coords) {
            [$x, $y] = json_decode($coords);
            unset($this->elfsLocations1[$elf]);
            $this->elfsLocations1[Helper::getKey($x, $y)] = [
                "x" => $x,
                "y" => $y
            ];
        }
    }

    private function updateMoveOptions():void
    {
        array_push($this->moveDirection, array_shift($this->moveDirection));
    }

    private function findMoves() {
        foreach($this->elfsLocations1 as $elf => $position) {
            ["x" => $x, "y" => $y] = $position;
            // echo "x: ". $x ." y: ". $y ."<br>";

            if($this->isAnyoneAround($x, $y)) {
                // echo "need to move<br>";
                $proposed[$elf] = $this->findMove($x, $y);
            } 
            // else {
            //     echo "No need to move<br>";
            // }
        }
        return $proposed;
    }

    private function findMove(int $x, int $y):string
    {
        foreach($this->moveDirection as $direction) {
            switch ($direction) {
                case "N":
                    if(!$this->checkToTheNorth($x, $y)) {
                        return Helper::getKey($x,$y+1);
                    }
                    break;
                case "S":
                    if(!$this->checkToTheSouth($x, $y)) {
                        return Helper::getKey($x,$y-1);
                    }
                    break;
                case "E":
                    if(!$this->checkToTheEast($x, $y)) {
                        return Helper::getKey($x+1,$y);
                    }
                    break;
                case "W":
                    if(!$this->checkToTheWest($x, $y)) {
                        return Helper::getKey($x-1,$y);
                    }
                    break;

            }
        }
    }

    private function checkToTheNorth(int $x, int $y) :bool
    {
        return (
            isset($this->elfsLocations1[Helper::getKey($x-1,$y+1)]) || // NE
            isset($this->elfsLocations1[Helper::getKey($x,$y+1)]) || // N
            isset($this->elfsLocations1[Helper::getKey($x+1,$y+1)]) // NW
        );
    }

    private function checkToTheSouth(int $x, int $y): bool
    {
        return (
            isset($this->elfsLocations1[Helper::getKey($x-1,$y-1)]) || // SE
            isset($this->elfsLocations1[Helper::getKey($x,$y-1)]) || // S
            isset($this->elfsLocations1[Helper::getKey($x+1,$y-1)]) // SW
        );
    }

    private function checkToTheEast(int $x, int $y): bool
    {
        return isset($this->elfsLocations1[Helper::getKey($x+1,$y)]); // E
    }

    private function checkToTheWest(int $x, int $y): bool
    {
        return isset($this->elfsLocations1[Helper::getKey($x-1,$y)]); // W
    }


    private function isAnyoneAround(int $x, int $y): bool
    {
        return (
            $this->checkToTheNorth($x, $y) ||
            $this->checkToTheSouth($x, $y) ||
            $this->checkToTheEast($x, $y) ||
            $this->checkToTheWest($x, $y)
        );
    }

    public function showGrid() {
        $minX = min((int)min(array_column($this->elfsLocations1, "x")),0);
        $maxX = max((int)max(array_column($this->elfsLocations1, "x")),5);
        $minY = min((int)min(array_column($this->elfsLocations1, "y")),0);
        $maxY = max((int)max(array_column($this->elfsLocations1, "y")),6);
        
        
        $table = "<table>";

        for($y=$minY;$y<$maxY+1;$y++) {
            $table .= "<tr>";
            for($x=$minX; $x<$maxX+1; $x++) {
                $table .= "<td>". (isset($this->elfsLocations1[Helper::getKey($x, $y)]) ? "#" : ".") ."</td>";
            }
            $table .= "</tr>";
        }
        return $table;
    }
}