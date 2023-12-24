<?php

namespace day18;

use common\Day;
use common\Helper;
use common\Picks;
use common\Shoelace;

class Day18 extends Day {
    /** @var array<mixed> */
    private $moves = [];
    /** @var array<mixed> */
    private $points = [];

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

    /**
     * @return array<int>
     */
    private function newPosition(string $direction): array {
        return match($direction) {
            "R" => [1, 0],
            "L" => [-1, 0],
            "U" => [0, -1],
            "D" => [0, 1],
            default => [0, 0]
        };
    }

    private function startDrilling(int $x, int $y): void {
        foreach($this->moves as $move) {
            $steps = $move["steps"];
            $direction = $move["direction"];
            [$xDirection, $yDirection] = $this->newPosition($direction);

            $x += $xDirection * $steps;
            $y += $yDirection * $steps;

            $this->points[] = [
                "x" => $x,
                "y" => $y,
            ];
        }
    }

    private function getInteriorPoints(): int {
        $areaSize = new Shoelace;
        $interiorPoints = new Picks;

        for($i=0;$i<count($this->points); $i++) {
            $z = $i+1;
            if($z >= count($this->points)) $z = 0;
        
            $areaSize->addPoints(
                $this->points[$i]["x"], 
                $this->points[$i]["y"], 
                $this->points[$z]["x"], 
                $this->points[$z]["y"]
            );
        }
        $interiorPoints->setArea($areaSize->getAreaSize());
        $interiorPoints->setBoundries($this->getExternalPoints());

        return $interiorPoints->calculateInteriorPoints();
    }

    private function convertHex(string $hex): int {
         return hexdec($hex);
    }

    private function convertMoveNumberToLetter(int $direction): string {
        return match($direction) {
            0 => "R",
            1 => "D",
            2 => "L",
            3 => "U",
            default => "X"
        };
    }

    private function getNewMoves(): void {
        $newMoves = [];
        foreach($this->moves as $move) {
            $newMoves[] =[
                "direction" => $this->convertMoveNumberToLetter((int) substr($move["color"], -1)),
                "steps" => $this->convertHex(substr($move["color"],1,5))
            ];
        }
        $this->moves = $newMoves;
    }

    private function getExternalPoints(): int {
        return array_sum(array_column($this->moves, "steps"));
    }

    public function part1(): int {
        $this->startDrilling(0,0);
        $this->getInteriorPoints();
        
        return $this->getInteriorPoints() + $this->getExternalPoints();
    }

    public function part2(): int {
        $this->getNewMoves();
        $this->startDrilling(0,0);
        $this->getInteriorPoints();
        
        return $this->getInteriorPoints() + $this->getExternalPoints();
    }
    
}
