<?php

namespace day22;

class Day221 {
    private array $currentPosition = ["x" => 6, "y"=> 6];
    private int $currentFacing = 1;    
    private int $moves = 8;
    private string $lineData = "  ............  ";
    
    public function setData($lineData, $moves, $facing) {
        $this->lineData = $lineData;
        $this->moves = $moves;
        $this->currentFacing = $facing;
    }

    public function part1() {
        return $this->getNewPosition($this->getCurrentPosition(), $this->moves);
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
    private function getCurrentPosition(): int {
        return (in_array($this->currentFacing, [0,1]) ? $this->currentPosition["x"] : $this->currentPosition["y"]);
    }

    private function getLineData(int $currentPosition): string {
        /**
         * TODO add logic to get the right row
         */
        return $this->lineData;
    }
}