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
        for($i=0; $i<3; $i++) {
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
        $rowData = $this->inputData[$currentX];

        $startColumn = $this->getFirstColumn($rowData);
        $endposition = $currentY + $numberOfSteps;
        $firstWallOnRow = strpos($rowData, "#", $startColumn);
        $nextWallAfterCurrentPosition = strpos($rowData, "#", $currentY);

        if($currentY + $numberOfSteps >= $nextWallAfterCurrentPosition) {
            $this->setCurrentPosition($currentX, $nextWallAfterCurrentPosition-1);
        }
    }

    private function checkMoveToDown(int $numberOfSteps): void {
        ["x" => $currentX, "y" => $currentY] = $this->currentPosition;
        $rowData = $this->inputData[$currentX];
        $startColumn = $this->getFirstColumn($rowData);
var_dump($this->inputData);
        $columnData = array_column($this->inputData, $currentY);
        var_dump($columnData);
        exit();

        
        $endposition = $currentY + $numberOfSteps;
        $firstWallOnRow = strpos($rowData, "#", $startColumn);
        $nextWallAfterCurrentPosition = strpos($rowData, "#", $currentY);

        if($currentY + $numberOfSteps >= $nextWallAfterCurrentPosition) {
            $this->setCurrentPosition($currentX, $nextWallAfterCurrentPosition-1);
        }
    }

    private function setStartingPosition(): void
    {
        $this->setCurrentPosition(0, $this->getFirstColumn($this->inputData[0]));
    }

    private function setCurrentPosition(int $x, int $y): void
    {
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