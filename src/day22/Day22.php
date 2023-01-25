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
        var_dump($this->currentPosition);
        $this->startMoving();
        var_dump($this->currentPosition);
        var_dump($this->currentFacing);
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
            // do move
            switch($this->currentFacing){
                case 0:
                    $this->checkMoveToRight($this->moves["steps"][$i]);
                    break;
                case 1:
                    $this->checkMoveToDown($this->moves["steps"][$i]);
                    break;
                case 2:
                    break;
                case 3:
                    break;
            }

            $this->changeFacing($this->moves["turns"][$i]);
            /** options
             * no wall (#) so just move
             * wall (#) as x, so max X moves
             * end of array (pos + moves > max width | 0) -> continue next line
             */
        }
    }

    private function changeFacing(string $rotation): void
    {
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

    private function checkMoveToRight(int $numberOfSteps): void {
        ["x" => $currentX, "y" => $currentY] = $this->currentPosition;
        $rowData = $this->getRowData($currentX);

        $startColumn = $this->getFirstColumn($rowData);
        $endposition = $currentY + $numberOfSteps;
        $firstWallPosition = strpos($rowData, "#", $startColumn);
        $nextWallAfterCurrentPosition = strpos($rowData, "#", $currentY);

        // echo "firstwall: ". $firstWallPosition;
        // echo "nextWall: ". $nextWallAfterCurrentPosition;

        if($currentX + $numberOfSteps >= $nextWallAfterCurrentPosition) {
            $this->setCurrentPosition($nextWallAfterCurrentPosition-1, $currentY);
        }
    }

    private function checkMoveToDown(int $numberOfSteps): void {
        ["x" => $currentX, "y" => $currentY] = $this->currentPosition;

        $columnData = $this->getColumnData($currentX);
        $startColumn = $this->getFirstColumn($columnData);

        $endposition = $currentY + $numberOfSteps;
        $firstWallPosition = strpos($columnData, "#", $startColumn);
        $nextWallAfterCurrentPosition = strpos($columnData, "#", $currentY);

        if($currentY + $numberOfSteps >= $nextWallAfterCurrentPosition) {
            $this->setCurrentPosition($currentX, $nextWallAfterCurrentPosition);
        } else {
            $this->setCurrentPosition($currentX, $currentY+$numberOfSteps);
        }
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
        echo "zet Y op: ". $y;
        $this->currentPosition = [
            "x" => $x, 
            "y" => $y
        ];
    }

    private function getFirstColumn(string $rowData): int
    {
        return min(strpos($rowData, "."), strpos($rowData, "#"));
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
            ($this->currentPosition["x"] - 1) * 1000 +
            ($this->currentPosition["y"] - 1)* 4 +
            $this->currentFacing;
        return $score;
    }
}