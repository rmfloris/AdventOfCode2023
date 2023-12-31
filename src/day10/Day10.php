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
    // private array $tilesInside = [];
    /** @var array<string> */
    private array $northFacing = [
        "|" => "|",
        "J" => "J",
        "L" => "L"
    ];

    protected function LoadData():void {
        parent::loadData();
        foreach($this->inputData as $y => $line) {
            for($x=0; $x<strlen($line); $x++) {
                $this->map[Helper::getKey($x, $y)] = $line[$x];
            }
        }
    }

    private function setStartingPoint(): void {
        $this->startPoint = array_search("S", $this->map);
    }

    private function findLoop(string $position):void {
        $neightbours = $this->findNeightbours($position);
 
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

    /**
     * @param array<mixed> $newLocations
     */
    private function getNewPosition($newLocations, string $prevLocation): string {
        unset($newLocations[$prevLocation]);
        return current($newLocations);
    }

    private function isSymbol(string $position): string | bool {
        return ($this->map[$position] != '.' ?  $this->map[$position] : false);
    }

    private function isValidNewPosition(string $position, string $currentPosition): bool  {
        if(!isset($this->map[$position])) return false;
        if(!$this->isSymbol($position)) return false;
        if(array_search($currentPosition, $this->newLocations($position))) return true;
        return false;
    }
    /**
     * @return array<mixed>
     */
    private function findNeightBours(string $position) {
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


    private function setVisitedLocation(string $location): void {
        [$x, $y] = Helper::getCoordsFromKey($location);
        $this->visitedLocations[$location] = ["x"=> $x, "y"=>$y];
    }

    /**
     * @return array<string>
     */
    private function newLocations(string $position): array {
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

        // Startingpoint S needs to be converted to J to match up.

        foreach($this->inputData as $y => $line) {
            $isInside = false;
            $allXCoords = array_filter($this->visitedLocations, fn($n) => $n["y"] == $y);
            if(empty($allXCoords)) continue;

            for($x=0; $x<strlen($line); $x++) {
                /** ToDo
                 * How to automatically have this tile being resolved?
                 */

                if($x == 109 && $y == 76) {
                    $line[109] = "J";
                }

                if(isset($this->visitedLocations[Helper::getKey($x, $y)]) && array_search($line[$x], $this->northFacing)) {
                    $isInside = !$isInside;
                    continue;
                }
                if(!isset($this->visitedLocations[Helper::getKey($x, $y)]) && $isInside) {

                    $this->numberOfTilesInsideLoop += 1;
                    // $this->tilesInside[Helper::getKey($x, $y)] = 1;
                }
            }           
        }
        return $this->numberOfTilesInsideLoop;
    }    
}
