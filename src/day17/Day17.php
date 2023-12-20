<?php

namespace day17;

use common\Day;
use common\Queue;

class Day17 extends Day {
    private $visited = [];
    private $height = 0;
    private $width = 0;
    private $grid = [];
    private $map = [];
    private $maxSteps = 3;

    protected function loadData(): void
    {
        parent::loadData();
       
        $this->height = count($this->inputData);
        $this->width = strlen($this->inputData[0]);


        foreach($this->inputData as $y => $line) {
            foreach(str_split($line) as $x => $value) {
                $key = json_encode([$x, $y]);

                $this->grid[$key] = [
                    "value" => 99999999,
                    "path" => []
                ];
                $this->map[$key] = $value;
            }
        }
    }

    private function outOfBound($x, $y) {
        return ($x < 0 || $x > $this->width-1 || $y <0 || $y>$this->height-1);
    }

    private function findNeighbours($x, $y, $prevX, $prevY, $xDirection, $yDirection, $steps) {
        $options = [];

        foreach([[1,0], [-1,0], [0,1], [0,-1]] as [$xChange, $yChange]) {
            $newX = $x + $xChange;
            $newY = $y + $yChange;
            
            //outside of the grid
            if($this->outOfBound($newX, $newY)) continue;
            // back to prev position
            if($newX === $prevX && $newY === $prevY) continue;
            
            if($xChange === $xDirection && $yChange === $yDirection) {
                // same direction
                // hierzo
                //
                // if($x === 12 && $y === 3) {
                //     echo "steps: ". $steps ."<br>";
                // }
                if($steps < $this->maxSteps) {
                    $newSteps = $steps + 1;
                } else {
                    // echo "to many steps on x: ". $newX ." y: ". $newY ." - steps: ". $steps ."<br>";
                    continue;
                }
            } else {
                $newSteps = 1;
            }

            $options[] = [$newX, $newY, $xChange, $yChange, $newSteps];
        }
        return $options;
    }

    private function newEntry($heatLoss, $newX, $newY, $currentX, $currentY, $directionX, $directionY, $steps, $path) {
        return [$heatLoss, $newX, $newY, $currentX, $currentY, $directionX, $directionY, $steps, $path];
    }

    private function loop($x, $y) {
        $queue = new Queue;

        $start = json_encode([$x,$y]);
        $queue->push($this->newEntry(0, 0, 0, -1, -1, 0, 1, 0, [$start]), 0);
        // $this->visited[json_encode([0, 0, 0, 1, 0])] = 1;
        $this->grid[$start] = [
            "value" => 0,
            "path" => $start
        ];
        
        $i=0;
        // print_r($this->grid);
        while($queue->isNotEmpty()) {
            [$heatLoss, $x, $y, $prevX, $prevY, $xDirection, $yDirection, $steps, $path] = $queue->shift();

            if ($x === $this->width-1 && $y === $this->height-1) {
                return [$heatLoss, $path];
            }
            
            // been before
            if (isset($this->visited[json_encode([$x, $y, $xDirection, $yDirection, $steps])])) {
                // echo "x: ". $x .", y: ". $y .", already visited<br>";
                continue;
            }
            $this->visited[json_encode([$x, $y, $xDirection, $yDirection, $steps])] = 1;

            // echo "<hr>";
            // echo "node --> ". $x ." - ". $y .", steps: ". $steps ."<br>";
            // $showY = 3;
            // if($x === 12 && $y === $showY) {
            //     echo "<hr>";
            //     echo "path --> ";
            //     print_r($path);
            //     echo "Steps: ". $steps ."<br>";
            //     echo "x: ". $xDirection .", y: ". $yDirection ."<br>";
            // }

            foreach($this->findNeighbours($x, $y, $prevX, $prevY, $xDirection, $yDirection, $steps) as $options) {
                // TODO add back to line above
                [$newX, $newY, $xNewDirection, $yNewDirection, $steps] = $options;
                // if($x === 12 && $y === $showY) {
                //     echo "options -->";
                //     print_r($options);
                // }

                $neightbour = json_encode([$newX, $newY]);
                // echo "neightbour: ". $neightbour ."<br>";
                // echo "current value: ". $this->grid[$neightbour]["value"] ."<br>";
                // echo "prev x,y: ". $prevX .", ". $prevY ."<br>";
                // print_r($options);

                $newValue = $heatLoss+$this->map[$neightbour];
                $newPath = array_merge($path, [$neightbour]);

                $queue->push($this->newEntry($newValue, $newX, $newY, $x, $y, $xNewDirection, $yNewDirection, $steps, $newPath), $newValue);
            }

            if($i>1000000) {
                echo"i-break!!!!";
                break;
            }
            $i++;
        }
    }

    public function getGrid() {
        return $this->grid;
    }

    public function part1(): int {
        // $this->loop(0,0);
        // $endPoint = json_encode([$this->width-1,$this->height-1]);
        // $endPoint = json_encode([3,1]);
        // print_r($this->grid);
        // echo "final path -->";
        // print_r($this->grid[$endPoint]["path"]);
        [$heatLoss, $path] = $this->loop(0,0);
        // print_r($path);
        return $heatLoss;
    }

    public function part2(): int {
        return 1;
    }
    
}
