<?php

namespace day10;

use common\Day;
use common\Helper;

class Day10 extends Day {
    /** @var array<mixed> */
    private array $moves = [
        "|" =>  [
                    ["x" => 0, "y" => -1],
                    ["x" => 0, "y" => 1]
        ], 
        "-" => [
                    ["x" => -1, "y" => 0],
                    ["x" => 1, "y" => 0]
        ],
        "L" => [
                    ["x" => 0, "y" => -1],
                    ["x" => 1, "y" => 0]
        ],
        "J" => [
                    ["x" => 0, "y" => -1],
                    ["x" => -1, "y" => 0]
        ],
        "7" => [
                    ["x" => -1, "y" => 0],
                    ["x" => 0, "y" => 1]
        ],
        "F" => [
                    ["x" => 1, "y" => 0],
                    ["x" => 0, "y" => 1]
        ],
    ];

    /** @var array<mixed> */
    private array $map = [];
    private string $startPoint = "";
    /** @var array<string> */
    private array $visitedLocations = [];
    private int $numberOfTilesInsideLoop = 0;

    protected function LoadData():void {
        parent::loadData();
        foreach($this->inputData as $y => $line) {
            for($x=0; $x<strlen($line); $x++) {
                $this->map[Helper::getKey($x, $y)] = $line[$x];
            }
        }
    }

    private function setStartingPoint() {
        $this->startPoint = array_search("S", $this->map);
    }

    private function findLoop($position) {
        $neightbours = $this->findNeightbours($position);
        $stack = [];
        $i=0;

        $startNeightbour = key($neightbours);
        $this->setVisitedLocation($this->startPoint);
        $this->setVisitedLocation($startNeightbour);
        
        $newPosition = $this->getNewPosition($this->newLocations($startNeightbour), $this->startPoint); //108,75
        $prevPosition = $startNeightbour; //108,76

        while($newPosition != $this->startPoint) {
            $this->setVisitedLocation($newPosition);
            $nextPrevPosition = $newPosition;
            $newPosition = $this->getNewPosition($this->newLocations($newPosition), $prevPosition);
            $prevPosition = $nextPrevPosition;

        }
    }

    private function getNewPosition($newLocations, $prevLocation) {
        unset($newLocations[$prevLocation]);
        return current($newLocations);
    }

    private function isSymbol($position): string | bool {
        return ($this->map[$position] != '.' ?  $this->map[$position] : false);
    }

    private function isValidNewPosition($position, $currentPosition) {
        if(!isset($this->map[$position])) return;
        if(!$this->isSymbol($position)) return;
        if(array_search($currentPosition, $this->newLocations($position))) return true;
        return;
    }

    private function findNeightBours($position, $symbol=false) {
        $stack = [];
        [$xCoord, $yCoord] = Helper::getCoordsFromKey($position);
        $xOptions = [-1, 1];
        $yOptions = [-1, 1];
        
        foreach($xOptions as $xOffset) {
            $xNew = $xCoord + $xOffset;
            $newPosition = Helper::getKey($xNew, $yCoord);
            
            if($this->isValidNewPosition($newPosition, $position)) {
                $stack[$newPosition] = $this->isSymbol($newPosition); 
            }
        }
        foreach($yOptions as $yOffset) {
            $yNew = $yCoord + $yOffset;
            $newPosition = Helper::getKey($xCoord, $yNew);
            
            if($this->isValidNewPosition($newPosition, $position)) {
                $stack[$newPosition] = $this->isSymbol($newPosition); 
            }
        }
        return $stack;
    }

    private function setVisitedLocation($location) {
        [$x, $y] = Helper::getCoordsFromKey($location);
        $this->visitedLocations[$location] = ["x"=> $x, "y"=>$y];
    }

    private function newLocations($position) {
        $moves = $this->moves[$this->map[$position]];
        [$xCoord, $yCoord] = Helper::getCoordsFromKey($position);
        $newPositions = [];
        foreach($moves as $move) {
            $x = $move["x"];
            $y = $move["y"];
            $xNew = $xCoord + $x;
            $yNew = $yCoord + $y;
            $newPosition = Helper::getKey($xNew, $yNew);
            $newPositions[$newPosition] = $newPosition;
        }
        return $newPositions;

    }

    public function part1(): int {
        $this->setStartingPoint();
        $this->findLoop($this->startPoint);
        // print_r(array_keys($this->visitedLocations));
        return count($this->visitedLocations) / 2;
    }

    public function part2(): int {
        $this->setStartingPoint();
        $this->findLoop($this->startPoint);
        // Helper::printRFormatted(($this->visitedLocations));
        foreach($this->inputData as $y => $line) {
            $allXCoords = array_filter($this->visitedLocations, fn($n) => $n["y"] == $y);
            if(empty($allXCoords)) continue;

            $xStart = min(array_column($allXCoords, "x"));
            for($x=$xStart; $x<strlen($line); $x++) {
                if(!isset($this->visitedLocations[Helper::getKey($x, $y)])) {
                    echo "x: ". $x ." - y: ". $y;
                    $numberOfLines = array_filter($this->visitedLocations, fn($n) => $n["x"] >= $x && $n["y"] == $y);
                    if(count($numberOfLines) % 2 != 0) {
                        echo " - count<br>";
                        $this->numberOfTilesInsideLoop += 1;
                    }
                    echo " - no count<br>";
                }
            }

            /**
             * 717 was too high
             */




            /**
             * Find first line (x value)
             * From that point onwards look for a value not in visited locations
             * count number of lines from that position
             * counter + 1 is number of lines is odd
             */
            
        }
        return $this->numberOfTilesInsideLoop;
    }
    
}
