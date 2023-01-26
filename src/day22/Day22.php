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
        echo "start\n";
        var_dump($this->currentPosition);
        $this->startMoving();
        var_dump($this->calculateFinalPassword());
        // var_dump($this->currentPosition);
        // var_dump($this->currentFacing);
        return $this->calculateFinalPassword();
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
            /** options
             * no wall (#) so just move
             * wall (#) as x, so max X moves
             * end of array (pos + moves > max width | 0) -> continue next line
             */
            $this->checkMove($this->moves["steps"][$i], $this->currentFacing);
            $this->changeFacing($this->moves["turns"][$i]);
            var_dump($this->currentPosition);
        }
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

    private function checkMove(int $numberOfSteps, int $direction): void 
    {
        ["x" => $currentX, "y" => $currentY] = $this->currentPosition;
        $lineData = $this->getData($currentX, $currentY, $direction);
        echo "line: |". $lineData ."|\n";
        echo "length: ". strlen($lineData) ."\n";
        $startOfMap = $this->getStartOfMap($lineData);
        echo "start of map: ". $startOfMap ."\n";
        $endOfMap = $this->getEndOfMap($lineData, $startOfMap);
        echo "end of map: ". $endOfMap ."\n";

        if($direction == 2 | $direction == 0) {
            $startPosition = $currentX;
            $newPosition = $currentX;
            $proposedPosition = $startPosition + ($numberOfSteps * ($direction == 2 ? -1 : 1));
        } else {
            $startPosition = $currentY;
            $newPosition = $currentY;
            $proposedPosition = $startPosition + ($numberOfSteps * ($direction == 3 ? -1 : 1));
        }
        echo "proposed Position: ". $proposedPosition ."\n";
        
        $firstWallPosition = $this->findNextWall($lineData, $direction, 0, $endOfMap);
        // $nextWallAfterCurrentPosition = $this->findNextWall($lineData, $direction, $startPosition, $endOfMap);

        if($newPosition = $this->hitWall(
                                $startPosition, 
                                $proposedPosition, 
                                $this->findNextWall($lineData, $direction, $startPosition, $endOfMap), 
                                $direction)) {
            echo "hit wall\n";
            echo "Wall: ". $this->findNextWall($lineData, $direction, $startPosition, $endOfMap) ."\n";
            echo "New position: ". $newPosition ."\n";
            // $newPosition = $nextWallAfterCurrentPosition-1;
        } elseif($this->fitsOnMap($startOfMap, $endOfMap, $proposedPosition, $direction) ) {
            // echo "To big\n";
            // echo "firstWall: ". $firstWallPosition ."\n";
            if($newPosition = $this->wallOnOtherSide($firstWallPosition, $startOfMap, $endOfMap, $direction)) {
                // echo "end of wall position\n";
                // echo "end of map:". $endOfMap ."\n";
                // $newPosition = $endOfMap;
            } else {
                if($direction < 2) {
                    $newProposedPosition = $startOfMap + ($proposedPosition - $endOfMap);
                    $startPosition = $startOfMap;
                }
                if($direction > 1) {
                    $newProposedPosition = $endOfMap - ($proposedPosition - $startOfMap);
                    $startPosition = $endOfMap;
                }
                // echo "new: ". $newProposedPosition ."\n";
                $newPosition = ($this->hitWall(
                                    $startPosition, 
                                    $newProposedPosition, 
                                    $this->findNextWall($lineData, $direction, $startPosition, $endOfMap), 
                                    $direction)
                                ? $this->hitWall(
                                    $startPosition, 
                                    $newProposedPosition, 
                                    $this->findNextWall($lineData, $direction, $startPosition, $endOfMap), 
                                    $direction)
                                : $newProposedPosition);
                // $newPosition = ($newProposedPosition >= $firstWallPosition ? $firstWallPosition - 1 : $newProposedPosition);
            }
        } else {
            // echo "Other\n";
            $newPosition = $proposedPosition;
        }
        switch($direction) {
            case 0:
            case 2:
                $newX = $newPosition;
                $newY = $currentY;
                break;
            case 1:
            case 3:
                $newX = $currentX;
                $newY = $newPosition;
                break;
        }
        $this->setCurrentPosition($newX, $newY);
    }

    private function hitWall(int $startPosition, int $proposedPosition, int $nextWall, int $direction): int|bool {
        if($direction < 2) {
            if($proposedPosition >= $nextWall && $startPosition < $nextWall) {
                return $nextWall-1;    
            }
        }
        if($direction > 1) {
            // left(2) of up(3)

            /**
             * -40 <= 137 && ?? > 137
             */
            echo "startPosition: ". $startPosition ."\n";
            echo "proposedPosition: ". $proposedPosition ."\n";
            echo "nextWall: ". $nextWall ."\n";
            if($proposedPosition <= $nextWall && $startPosition > $nextWall) {
                return $nextWall+1;
            }
        }
        return false;
    }

    private function fitsOnMap(int $startOfMap, int $endOfMap, int $proposedPosition, int $direction): bool {
        if($direction < 2) {
            if($proposedPosition >= $endOfMap) return true;
        }
        if($direction > 1) {
            if($proposedPosition <= $startOfMap) return true;
        }
        return false;        
    }

    private function findNextWall(string $lineData, int $direction, int $currentPosition, int $endOfMap): int 
    {
        if($direction < 2) {
            return strpos($lineData, "#", $currentPosition);
        }
        if($direction > 1) {
            // $reversedLineData = strrev($lineData);
            // $startOfMap = $this->getStartOfMap($reversedLineData);

            // echo "Line: ". $lineData ."\n";
            // echo "rev: ". $reversedLineData ."\n";
            // echo "start: ".$this->getStartOfMap($reversedLineData) ."\n";
            // echo "#: ". strpos($reversedLineData, "#", $startOfMap) - $startOfMap ."\n";
            // echo "outcome strrpos: ". strrpos(strrev($lineData), "#", $endOfMap - $currentPosition) ."\n";
            // return $endOfMap - strrpos(strrev($lineData), "#", $endOfMap - $currentPosition) -1;
            // echo "test: ". strrpos($lineData, "#") ."\n";
            return strrpos($lineData, "#");
            // return strpos($reversedLineData, "#", $startOfMap) - $startOfMap;
        }
    }

    private function wallOnOtherSide(int $firstWall, int $startOfMap, int $endOfMap, int $direction): int|bool {
        if($direction < 2) {
            return $firstWall == $startOfMap ? $endOfMap : false;
        }
        if($direction > 1) {
            return $firstWall == $endOfMap ? $startOfMap : false;
        }
        return false;
    }

    private function getData(int $x, int $y, int $direction): string
    {
        if($direction == 2 | $direction == 0){
            return $this->getRowData($y);
        }
        if($direction == 3 | $direction == 1) {
            return $this->getColumnData($x);
        }
        return "";
    }

    private function getRowData(int $row): string
    {
        return $this->inputData[$row];
    }

    private function getColumnData(int $column): string
    {
        $columnData = "";
        for($i=0; $i<count($this->inputData); $i++) {
            $columnData .= $this->inputData[$i][$column] ?? " ";
        }
        return $columnData;
    }

    private function setStartingPosition(): void
    {
        $this->setCurrentPosition($this->getFirstColumn($this->inputData[0]), 0);
    }

    private function setCurrentPosition(int $x, int $y): void
    {
        // echo "zet Y op: ". $y;
        $this->currentPosition = [
            "x" => $x, 
            "y" => $y
        ];
    }

    private function getFirstColumn(string $rowData): int
    {
        return min(strpos($rowData, "."), strpos($rowData, "#"));
    }

    private function getStartOfMap(string $lineData): int
    {
        return min(strpos($lineData, "."), strpos($lineData, "#"));
    }

    private function getEndOfMap(string $lineData, int $startOfMap): int 
    {
        // $temp = "";
        // echo $startOfMap;
        // if(!strpos($lineData, " ", $startOfMap)) {
        //     echo "not found\n";
        //     $temp = strlen($lineData)-1;
        // } else {
        //     echo "overig\n";
        //     $temp = strpos($lineData, " ", $startOfMap) - 1 + $startOfMap;
        // }
        // return $temp;
        return (!strpos($lineData, " ", $startOfMap) ? strlen($lineData) : strpos($lineData, " ", $startOfMap) - 1 + $startOfMap);
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