<?php

namespace day21;

use common\Day;
use common\Queue;

class Day21 extends Day {

    /** @var array<int, array<int>> */
    private array $map;
    /** @var array<array{x: int, y: int}> */
    private array $startingPoint;
    private int $steps = 0;
    
    
    protected function loadData(): void
    {
        parent::loadData();
        foreach($this->inputData as $y => $row) {
            $squares = str_split($row);
            if($position = array_search("S", $squares)) {
                // echo "position found: ". $position ."<br>";
                $this->startingPoint = ["x" => $position, "y"=> $y];
            }

            $this->map[$y] = $squares;
        }
    }

    private function newPositions(int $x, int $y) {
        $options = [];
        foreach([[1,0], [-1,0], [0,1], [0,-1]] as [$xChange, $yChange]) {
            $newX = $x + $xChange;
            $newY = $y + $yChange;
            if($this->map[$newY][$newX] != "#") {
                $options[] = [
                    "x" => $newX,
                    "y" => $newY
                ];
            }
        }
        return $options;
    }

    private function startWalking(): int {
        $queue = new Queue;
        $queue->insert($this->startingPoint);
        
        for($i=0;$i<$this->steps;$i++) {
            $newSteps = [];
            while($queue->isNotEmpty()) {
                ["x" => $x, "y" => $y] = $queue->shift();
        
        
                foreach($this->newPositions($x, $y) as $option) {
                    ["x" => $x, "y" => $y] = $option;
                    $newSteps[json_encode([$x,$y])] = $option;
                }          
            }
            foreach($newSteps as $newStep) {
                $queue->insert($newStep);
            }
        }
        return count($queue->show());
    }

    public function setSteps(int $steps): void {
        $this->steps = $steps;
    }

    public function part1(): int {
        return $this->startWalking();
    }

    public function part2(): int {
        return 1;
    }
    
}
