<?php

namespace day17;

use common\Day;
use \SplPriorityQueue;

class Heap extends SplPriorityQueue
{
    public function compare($priority1, $priority2) : int
    {
        return parent::compare($priority2,$priority1);
    }
}

class Day17 extends Day {
    /** @var array<mixed> */
    private $visited = [];
    private int $height = 0;
    private int $width = 0;
    /** @var array<mixed> */
    private $map = [];
    private int $maxStepsWithoutTurning = 3;
    private int $minBlocksAfterTurning = 0;

    protected function loadData(): void
    {
        parent::loadData();
       
        $this->height = count($this->inputData);
        $this->width = strlen($this->inputData[0]);

        foreach($this->inputData as $y => $line) {
            foreach(str_split($line) as $x => $value) {
                $this->map[$y][$x] = $value;
            }
        }
    }

    private function outOfBound(int $x, int $y): bool {
        return ($x < 0 || $x > $this->width-1 || $y <0 || $y>$this->height-1);
    }

    /**
     * @return array<mixed>
     */
    private function findNeighbours(int $x, int $y, int $prevX, int $prevY, int $xDirection, int $yDirection, int $steps): array {
        $options = [];

        foreach([[1,0], [-1,0], [0,1], [0,-1]] as [$xChange, $yChange]) {
            $newX = $x + $xChange;
            $newY = $y + $yChange;
            
            //outside of the grid
            if($this->outOfBound($newX, $newY)) continue;
            // back to prev position
            if($newX === $prevX && $newY === $prevY) continue;
            
            if($xChange === $xDirection && $yChange === $yDirection) {
                if($steps < $this->maxStepsWithoutTurning) {
                    $newSteps = $steps + 1;
                } else {
                    continue;
                }
            } else {
                if([$x, $y] === [0,0] || $steps >= $this->minBlocksAfterTurning ) {
                    $newSteps = 1;
                } else {
                    continue;
                }
            }
            $options[] = [$newX, $newY, $xChange, $yChange, $newSteps];
        }
        return $options;
    }

    /**
     * @return array<mixed>
     */
    private function newEntry(int $heatLoss, int $newX, int $newY, int $currentX, int $currentY, int $directionX, int $directionY, int $steps): array {
        return ["heatloss" => $heatLoss, "x" => $newX, "y"=> $newY, "prevX" => $currentX, "prevY" => $currentY, "directionX" => $directionX, "directionY" => $directionY, "steps" => $steps];
    }

    private function loop(int $x, int $y): int {
        $queue = new Heap;
        $queue->insert($this->newEntry(0, $x, $y, -1, -1, 0, 1, 0), 0);
       
        while($queue->count() > 0) {
            ["heatloss" => $heatLoss, "x" => $x, "y" => $y, "prevX" => $prevX, "prevY" => $prevY, "directionX" => $xDirection, "directionY" => $yDirection, "steps" => $steps] = $queue->extract();

            if ($x === $this->width-1 && $y === $this->height-1) {
                if ($steps >= $this->minBlocksAfterTurning) {
                    return $heatLoss;
                }
            }
            // been before
            if (isset($this->visited[json_encode([$x, $y, $xDirection, $yDirection, $steps])])) continue;
            $this->visited[json_encode([$x, $y, $xDirection, $yDirection, $steps])] = 1;

            foreach($this->findNeighbours($x, $y, $prevX, $prevY, $xDirection, $yDirection, $steps) as $options) {
                [$newX, $newY, $xNewDirection, $yNewDirection, $steps] = $options;
                $newValue = $heatLoss+$this->map[$newY][$newX];

                $queue->insert($this->newEntry($newValue, $newX, $newY, $x, $y, $xNewDirection, $yNewDirection, $steps), $newValue);
            }
        }
        return 0;
    }

    private function setMaxStepsBeforeTurning(int $maxSteps): void {
        $this->maxStepsWithoutTurning = $maxSteps;
    }

    private function setMinBlocksAfterTurning(int $minSteps): void {
        $this->minBlocksAfterTurning = $minSteps;
    }

    public function part1(): int {
        $this->setMaxStepsBeforeTurning(3);
        return $this->loop(0,0);
    }

    public function part2(): int {
        $this->setMaxStepsBeforeTurning(10);
        $this->setMinBlocksAfterTurning(4);
        return $this->loop(0,0);
    }    
}