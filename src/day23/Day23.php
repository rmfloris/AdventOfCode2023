<?php

namespace day23;

use common\Day;
use common\Helper;

class Day23 extends Day {
    private array $moveDirection = ["N", "S", "W", "E"];
    // private array $elfsLocations; // contains X-Y coords
    private array $elfsLocations1; // contains X-Y coords
    private int $rounds = 0;
    private bool $noMoreMoves = false;

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
            // echo "round #". $i ."<br>";
            $this->rounds = $i;
            if(!$proposals = $this->findMoves()) {
                $this->noMoreMoves = true;
                break;

            }
                
            // print_r($proposals);
            $proposals = $this->checkProposals($proposals);
            // print_r($proposals);
            $this->performProposals($proposals);
            // print_r($this->elfsLocations1);

            $this->updateMoveOptions();
        }
    }

    private function checkProposals(array $proposals):array
    {
        $emptyKeys = array_keys($proposals, "");
        
        if(count($emptyKeys) >= 1) {
            foreach($emptyKeys as $key) {
                unset($proposals[$key]);
            }
        }

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
            if(is_null($x)) {
                echo "null for x<br>";
                echo "round: ". $this->rounds ."<br>";
                print_r($proposals);
            }
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
        $proposed = [];
        foreach($this->elfsLocations1 as $elf => $position) {
            ["x" => $x, "y" => $y] = $position;
            // if($x == 73 && $y == 85 && $this->rounds == 804) {
            //     echo "x: ". $x ." y: ". $y ."<br>";
            // }

            if($this->isAnyoneAround($x, $y)) {
                // echo "need to move<br>";
                $proposed[$elf] = $this->findMove($x, $y);
                
                // if($x == 73 && $y == 85 && $this->rounds == 804) {
                //     echo "proposal -> ". print_r($proposed[$elf], true) ."<br>";
                // }
            }
            else {
                // if($x == 73 && $y == 85 && $this->rounds == 804) {
                //     echo "No need to move<br>";
                // }
            }
        }
        return $proposed;
    }

    private function findMove(int $x, int $y):string|bool
    {
        // echo "x: ". $x ." - y: ". $y ."<br>";
        foreach($this->moveDirection as $direction) {
            switch ($direction) {
                case "N":
                    // echo "checkin North<br>";
                    if(!$this->canMoveToTheNorth($x, $y)) {
                        // echo "propose to move North<br>";
                        return Helper::getKey($x,$y-1);
                    }
                    break;
                case "S":
                    // echo "checkin South<br>";
                    if(!$this->canMoveToTheSouth($x, $y)) {
                        // echo "propose to move South<br>";
                        return Helper::getKey($x,$y+1);
                    }
                    break;
                case "E":
                    // echo "checkin East<br>";
                    if(!$this->canMoveToTheEast($x, $y)) {
                        // echo "propose to move East<br>";
                        return Helper::getKey($x+1,$y);
                    }
                    break;
                case "W":
                    // echo "checkin West<br>";
                    if(!$this->canMoveToTheWest($x, $y)) {
                        // echo "propose to move West<br>";
                        return Helper::getKey($x-1,$y);
                    }
                    break;
            }
        }
        // echo "no moves possible<br>";
        return "";
    }

    private function canMoveToTheNorth(int $x, int $y) :bool
    {
        return (
            isset($this->elfsLocations1[Helper::getKey($x+1,$y-1)]) ||  // NE
            isset($this->elfsLocations1[Helper::getKey($x,$y-1)])   ||  // N
            isset($this->elfsLocations1[Helper::getKey($x-1,$y-1)])     // NW
        );
    }

    private function canMoveToTheSouth(int $x, int $y): bool
    {
        return (
            isset($this->elfsLocations1[Helper::getKey($x+1,$y+1)]) ||  // SE
            isset($this->elfsLocations1[Helper::getKey($x,$y+1)])   ||  // S
            isset($this->elfsLocations1[Helper::getKey($x-1,$y+1)])     // SW
        );
    }

    private function canMoveToTheEast(int $x, int $y): bool
    {
        return (
            isset($this->elfsLocations1[Helper::getKey($x+1,$y-1)]) ||  // NE
            isset($this->elfsLocations1[Helper::getKey($x+1,$y)])   ||  // E
            isset($this->elfsLocations1[Helper::getKey($x+1,$y+1)])     // SE
        );
    }

    private function canMoveToTheWest(int $x, int $y): bool
    {
        return (
            isset($this->elfsLocations1[Helper::getKey($x-1,$y-1)]) ||  // NW
            isset($this->elfsLocations1[Helper::getKey($x-1,$y)])   ||  // W
            isset($this->elfsLocations1[Helper::getKey($x-1,$y+1)])     // SW
        );
    }


    private function isAnyoneAround(int $x, int $y): bool
    {
        return (
            $this->canMoveToTheNorth($x, $y) ||
            $this->canMoveToTheSouth($x, $y) ||
            $this->canMoveToTheEast($x, $y) ||
            $this->canMoveToTheWest($x, $y)
        );
    }

    public function showGrid() {
        $minX = min((int)min(array_column($this->elfsLocations1, "x")),0);
        $maxX = max((int)max(array_column($this->elfsLocations1, "x")),5);
        $minY = min((int)min(array_column($this->elfsLocations1, "y")),0);
        $maxY = max((int)max(array_column($this->elfsLocations1, "y")),6);
        
        
        $table = "<table>";
        $table .= "<tr><th>&nbsp;</th>";
        foreach(range($minX, $maxX) as $value) {
            $table .= "<th>". $value ."</th>";
        }
        $table .= "</tr>";
        

        for($y=$minY;$y<$maxY+1;$y++) {
            $table .= "<tr>";
            $table .= "<th>". $y ."</th>";
            for($x=$minX; $x<$maxX+1; $x++) {
                $table .= "<td>". (isset($this->elfsLocations1[Helper::getKey($x, $y)]) ? "#" : ".") ."</td>";
            }
            $table .= "</tr>";
        }
        return $table;
    }

    public function countEmptyGround(): int
    {
        $minX = (int)min(array_column($this->elfsLocations1, "x"));
        $maxX = (int)max(array_column($this->elfsLocations1, "x"));
        $minY = (int)min(array_column($this->elfsLocations1, "y"));
        $maxY = (int)max(array_column($this->elfsLocations1, "y"));

        // echo $minX ." x ". $maxX ." x ". $minY ." x ". $maxY ."<br>";
        // echo count(range($minX, $maxX)) ."<br>";
        // echo count(range($minY, $maxY)) ."<br>";
        // echo (count(range($minX, $maxX))*count(range($minY, $maxY))) ."<br>";

        // echo "aantal: ". count($this->elfsLocations1) ."<br>";

        return (count(range($minX, $maxX))*count(range($minY, $maxY)))-count($this->elfsLocations1);
    }

    public function getRounds(): int
    {
        return ($this->noMoreMoves ? $this->rounds : 0);
    }
}