<?php

namespace day22;

use common\Day;

class Day22 extends Day {
    /** @var array<mixed> */
    private array $currentPosition;
    private int $currentFacing = 0;
    /** @var array<mixed> */
    private array $visitedSpots;
    /** @var array<mixed> */
    private array $moves;
    
    public function loadData(): void 
    {
        parent::loadData();
        $this->getMovesFromFile();
        $this->setStartingPosition();
    }

    /**
     * @param array<mixed> $moves
     * @param array<mixed> $currentPosition
     */
    public function setData(int $currentFacing, array $moves, array $currentPosition): void {
        $this->currentFacing = $currentFacing;
        $this->moves = $moves;
        $this->currentPosition = $currentPosition;
    }

    /**
     * @return array<mixed>
     */
    public function getData(): array {
        return [
            "currentPosition" => $this->currentPosition,
            "moves" => $this->moves,
            "currentFacing" => $this->currentFacing
        ];
    }

    public function part1(): int 
    {
        $this->startMoving();
        return $this->calculateFinalPassword();
    }

    public function part2(): int
    {
        return 0;
    }

    public function startMoving(): void 
    {
        for($i=0; $i<count($this->moves["steps"]); $i++) {
            $newPosition = $this->getNewPosition($this->getCurrentPosition(), $this->moves["steps"][$i]);
            $this->updateCurrentPosition($newPosition, $this->moves["steps"][$i]);
            $this->changeFacing($this->moves["turns"][$i]);
        }
    }

    private function getMovesFromFile(): void
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
        return (in_array($this->currentFacing, [0,2]) ? $this->currentPosition["x"] : $this->currentPosition["y"]);
    }

    private function setStartingPosition(): void
    {
        $this->setCurrentPosition($this->getStartOfMap($this->inputData[0]), 0);
    }

    private function updateCurrentPosition(int $value, int $steps): void
    {
        (in_array($this->currentFacing, [0,2]) 
            ? $this->setCurrentPosition($value, $this->currentPosition["y"], $steps)
            :$this->setCurrentPosition($this->currentPosition["x"], $value, $steps)
        );
    }

    private function setCurrentPosition(int $x, int $y, int $steps = null): void
    {
        $this->currentPosition = [
            "x" => $x, 
            "y" => $y
        ];
        $this->visitedSpots[] = [
            "stepsDone" => $steps,
            "currentFacing" => $this->currentFacing,
            "x" => $x, 
            "y" => $y
        ];
    }

    /**
     * @return array<mixed>
     */
    public function getVisitedSpots(): array
    {
        return $this->visitedSpots;
    }

    private function getNewPosition(int $currentPosition, int $moves): int {
        $this->printOut("--", "---------------------");
        $this->printOut("currentPosition", $currentPosition);
        $this->printOut("moves", $moves);
        $lineData = $this->getLineData();
        $nextWall = $this->findNextWall($lineData, $currentPosition);
        $this->printOut("Next wall at", $nextWall);
        $proposedPosition = $currentPosition + ($moves * (in_array($this->currentFacing, [0,1]) ?  1 : -1));
        $this->printOut("ProposedPosition", $proposedPosition);
        
        $this->printOut("hit a wall", "?");
        $newPosition = $this->hitWall($nextWall, $proposedPosition);
        if($newPosition !== false) {
            return $newPosition;
        }
        // if($newPosition = $this->hitWall($nextWall, $proposedPosition)) { echo $newPosition ."--\n"; return $newPosition; }
        $this->printOut("result:", "didn't hit wall");
        $newPosition = $this->fitsOnMap($proposedPosition, $lineData);
        if($newPosition !== false) {
            return $newPosition;
        }
        // if($newPosition = $this->fitsOnMap($proposedPosition, $lineData)) { return $newPosition; }
        $this->printOut("fits", "doesn't fit on map");
        if($this->isWallOnOtherEnd($lineData)) { return (in_array($this->currentFacing, [0,1]) ?  $this->getEndOfMap($lineData) : $this->getStartOfMap($lineData)); }
        $this->printOut("other end", "no wall on other end");
        
        $newCurrentPosition = (in_array($this->currentFacing, [0,1]) ?  $this->getStartOfMap($lineData)-1 : $this->getEndOfMap($lineData)+1);
        $newMoves = abs($this->movesOverEdgeOfMap($lineData, $proposedPosition));
        $this->printOut("new run", "yes, new run");
        return $this->getNewPosition($newCurrentPosition, $newMoves);
    }

    private function movesOverEdgeOfMap(string $lineData, int $proposedPosition): int {
        return (in_array($this->currentFacing, [0,1])
            ? $this->getEndOfMap($lineData) - $proposedPosition
            : $proposedPosition - $this->getStartOfMap($lineData)
        );
    }

    private function fitsOnMap(int $proposedPosition, string $lineData): int|bool {
        if($this->movesOverEdgeOfMap($lineData, $proposedPosition) < 0) { return false; } 
        return $proposedPosition;
    }

    private function isWallOnOtherEnd(string $lineData): bool {
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
        return min(array_diff(
            [
                strpos($lineData, "."),
                strpos($lineData, "#")
            ], array(false)));
    }

    private function getEndOfMap(string $lineData): int 
    {
        return strlen($lineData) - $this->getStartOfMap(strrev($lineData)) - 1;
    }

    private function hitWall(int|bool $nextWall, int $proposedPosition): int|bool {
        if($nextWall === false) { return false; }
        if(in_array($this->currentFacing, [0,1])) {
            $this->printOut("new position", ($proposedPosition >= $nextWall ? $nextWall-1 : $proposedPosition));
            return ($proposedPosition >= $nextWall ? $nextWall-1 : $proposedPosition);
        }
        if(in_array($this->currentFacing, [2,3])) {
            return ($proposedPosition <= $nextWall ? $nextWall+1 : $proposedPosition);
        }
        return false;
    }

    private function findNextWall(string $lineData, int $currentPosition): int|bool {
        switch($this->currentFacing){
            case 0:
            case 1:
                $currentPosition = ($currentPosition < 0 ? 0 : $currentPosition);
                return strpos($lineData, "#", $currentPosition);
            case 2:
            case 3:
                return strrpos(substr($lineData,0, $currentPosition), "#");
        }
        return false;
    }

    private function changeFacing(string $rotation): void
    {
        /**
         * 0 = R
         * 1 = D
         * 2 = L
         * 3 = U
         */
        switch($rotation) {
            case "R":
                $this->incrementFacing();
                break;
            case "L":
                $this->decreaseFacing();
                break;
        }
    }

    private function incrementFacing(): void
    {
        $newValue = $this->currentFacing + 1;
        $this->currentFacing = $newValue > 3 ? 0 : $newValue;
    }

    private function decreaseFacing(): void
    {
        $newValue = $this->currentFacing - 1;
        $this->currentFacing = $newValue < 0 ? 3 : $newValue;
    }

    private function getLineData(): string
    {
        return (in_array($this->currentFacing, [0,2])
            ? $this->getRowData()
            : $this->getColumnData()
        );
    }

    private function getRowData(): string
    {
        return $this->inputData[$this->currentPosition["y"]];
    }

    private function getColumnData(): string
    {
        $columnData = "";
        for($i=0; $i<count($this->inputData); $i++) {
            $columnData .= $this->inputData[$i][$this->currentPosition["x"]] ?? " ";
        }
        return $columnData;
    }

    private function calculateFinalPassword(): int
    {
        $score = 0;
        $score = 
            ($this->currentPosition["y"] + 1) * 1000 +
            ($this->currentPosition["x"] + 1) * 4 +
            $this->currentFacing;
        return $score;
    }
}