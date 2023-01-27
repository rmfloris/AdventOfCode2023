<?php

namespace day22;

use common\Day;

class Day22 extends Day {
    /** @var array<mixed> */
    private array $currentPosition;
    private int $currentFacing = 0;
    /** @var array<mixed> */
    private array $moves;
    
    public function loadData(): void 
    {
        parent::loadData();
        $this->getMoves();
        $this->setStartingPosition();
    }

    public function part1(): int 
    {
        $this->startMoving();
        return $this->calculateFinalPassword();
        return 0;
    }

    public function part2(): int
    {
        return 0;
    }

    private function startMoving(): void 
    {
        // for($i=0; $i<count($this->moves["steps"]); $i++) {
        for($i=0; $i<2; $i++) {
            echo "\n---------------------------------------------------------------\n";
            echo "loop ". $i ."\n";
            echo "number of steps: ". $this->moves["steps"][$i] ."\n";
            echo "direction: ". $this->currentFacing ."\n";

            $newPosition = $this->getNewPosition($this->getCurrentPosition(), $this->moves["steps"][$i]);
            $this->setNewPosition
            $this->changeFacing($this->moves["turns"][$i]);
        }
    }

    private function getMoves(): void
    {
        foreach($this->inputData as $id => $line) {
            if(strlen($line) == 0) {
                $this->moves = $this->breakupMoves($this->inputData[$id + 1]);
                $this->removeLinesFromInput($id);
            }
        }
    }

    private function removeLinesFromInput(int $startRow): void 
    {
        array_splice($this->inputData, $startRow);
    }

    /**
     * @return array<mixed>
     */
    private function breakupMoves(string $moveLine): array 
    {
        $moves = [];

        $regex = "#(\d{1,})([A-Z]{1})?#";
        preg_match_all($regex, $moveLine, $matches);

        $moves = [
            "steps" => $matches[1],
            "turns" => $matches[2]
        ];

        return $moves;
    }

    private function getCurrentPosition(): int {
        return (in_array($this->currentFacing, [0,1]) ? $this->currentPosition["x"] : $this->currentPosition["y"]);
    }

    private function setStartingPosition(): void
    {
        $this->setCurrentPosition($this->getFirstColumn($this->inputData[0]), 0);
    }

    private function updateCurrentPosition($value): void
    {
        (in_array($this->currentFacing, [0,2]) 
            ? $this->setCurrentPosition($value, $this->currentPosition["y"])
            :$this->setCurrentPosition($this->currentPosition["x"], $value)
    );
    }

    private function setCurrentPosition(int $x, int $y): void
    {
        $this->currentPosition = [
            "x" => $x, 
            "y" => $y
        ];
    }

    private function getNewPosition(int $currentPosition, int $moves) {
        // echo "\n----------------\n";
        // echo "currentPosition: ". $currentPosition ."\n";
        // echo "moves: ". $moves ."\n";
        $lineData = $this->getLineData($currentPosition);
        $nextWall = $this->findNextWall($lineData, $currentPosition);
        $proposedPosition = $currentPosition + ($moves * (in_array($this->currentFacing, [0,1]) ?  1 : -1));

        if($newPosition = $this->hitWall($nextWall, $proposedPosition)) { return $newPosition; }
        // echo "didn't hit wall\n";
        if($this->isWallOnOtherEnd($lineData)) { return (in_array($this->currentFacing, [0,1]) ?  $this->getEndOfMap($lineData) : $this->getStartOfMap($lineData)); }
        // echo "No Wall on other end\n";
        if($newPosition = $this->fitsOnMap($proposedPosition, $lineData)) { return $newPosition; }
        // echo "Doesn't fit on map\n";
        
        $newCurrentPosition = (in_array($this->currentFacing, [0,1]) ?  $this->getStartOfMap($lineData)-1 : $this->getEndOfMap($lineData)+1);
        $newMoves = abs($this->movesOverEdgeOfMap($lineData, $proposedPosition));
        return $this->getNewPosition($newCurrentPosition, $newMoves);

        // return "unknown";
        // return $proposedPosition;
    }

    private function movesOverEdgeOfMap($lineData, $proposedPosition) {
        // echo "end: ". $this->getEndOfMap($lineData) ."\n";
        // echo "prop: ". $proposedPosition ."\n";
        return (in_array($this->currentFacing, [0,1])
            ? $this->getEndOfMap($lineData) - $proposedPosition
            : $proposedPosition - $this->getStartOfMap($lineData)
        );
        
    }

    private function fitsOnMap(int $proposedPosition, string $lineData): int|bool {
        // echo "moves over: ". $this->movesOverEdgeOfMap($lineData, $proposedPosition) ."\n";
        if($this->movesOverEdgeOfMap($lineData, $proposedPosition) < 0) { return false; } 
        return $proposedPosition;
    }

    private function isWallOnOtherEnd($lineData): bool {
        if(in_array($this->currentFacing, [0,1])) {
            return ($lineData[$this->getStartOfMap($lineData)] == "#" ? true : false);
        }
        if(in_array($this->currentFacing, [2,3])) {
            return ($lineData[$this->getEndOfMap($lineData)] == "#" ? true : false);
        }
        return false;
    }

    private function getStartOfMap(string $lineData): int
    {
        $r = array_diff(
            [
                strpos($lineData, "."),
                strpos($lineData, "#")
            ], array(false));
        return min($r);
        return min(strpos($lineData, "."), strpos($lineData, "#"));
    }

    private function getEndOfMap(string $lineData): int 
    {
        // echo "len: ". strlen($lineData) ."\n";
        // echo "start: ". $this->getStartOfMap(strrev($lineData)) ."\n";
        return strlen($lineData) - $this->getStartOfMap(strrev($lineData)) - 1;
    }

    private function hitWall(int|bool $nextWall, int $proposedPosition) {
        if($nextWall === false) { return false; }
        if(in_array($this->currentFacing, [0,1])) {
            return ($proposedPosition >= $nextWall ? $nextWall-1 : $proposedPosition);
        }
        if(in_array($this->currentFacing, [2,3])) {
            return ($proposedPosition <= $nextWall ? $nextWall+1 : $proposedPosition);
        }
    }

    private function findNextWall(string $lineData, int $currentPosition): int|bool {
        switch($this->currentFacing){
            case 0:
            case 1:
                return strpos($lineData, "#", $currentPosition);
            case 2:
            case 3:
                return strrpos(substr($lineData,0, $currentPosition), "#");
        }
    }

}