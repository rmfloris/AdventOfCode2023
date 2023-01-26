<?php

namespace day17;

use common\Day;

class Day17 extends Day {

    private int $moveIndex = 0;
    /** @var array<mixed> */
    private array $shapes = [
        [
            [1, 1, 1, 1,]
        ],
        [
            [0, 1, 0,],
            [1, 1, 1,],
            [0, 1, 0,],
        ],
        [
            [0, 0, 1,],
            [0, 0, 1,],
            [1, 1, 1,],
        ],
        [
            [1,],
            [1,],
            [1,],
            [1,],
        ],
        [
            [1, 1,],
            [1, 1,],
        ]
    ];

    protected function loadData(): void
    {
        parent::loadData();
        $this->inputData = str_split($this->inputData[0]);
    }

    public function part1(): int 
    {
        return 0;
    }

    public function part2(): int 
    {
        return 0;
    }

    public function startMoving(int $moves = 5): void
    {
        $shapeIndex = 0;
        $chamber = [];
        for($i=0; $i<$moves;$i++){
            $this->applyMovement($shapeIndex);

            $shapeIndex = ($shapeIndex + 1) % count($this->shapes);
        }
        /**
         * Start position
         * left edge is two units away from the left wall
         * bottom edge is three units above the highest rock
         */

        /**
         * push
         * move down
         * stopped if it goes into the floor
         */
    }

    private function applyMovement(int $shapeIndex): void {
        $shape = $this->shapes[$shapeIndex];
        $left = 2;
        $bottom = 0;
        $top = count($shape)-3;

        $i=0;
        while(true) {
            $move = $this->inputData[$this->moveIndex];
            $this->moveIndex = ($this->moveIndex + 1) % count($this->inputData);

            
            echo $move ."<br>";
            if($i == 2) break;
            $i++;
        }
    }
}