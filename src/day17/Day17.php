<?php

namespace day17;

use common\Day;
use common\Queue;

class Day17 extends Day {
    /** @var array<mixed> */
    private $visited = [];
    private int $height = 0;
    private int $width = 0;
    /** @var array<mixed> */
    private $grid = [];
    /** @var array<mixed> */
    private $map = [];
    private int $maxSteps = 3;

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

    /**
     * @return array<mixed>
     */
    private function newEntry(int $heatLoss, int $newX, int $newY, int $currentX, int $currentY, int $directionX, int $directionY, int $steps): array {
        return ["heatloss" => $heatLoss, "x" => $newX, "y"=> $newY, "prevX" => $currentX, "prevY" => $currentY, "directionX" => $directionX, "directionY" => $directionY, "steps" => $steps];
    }

    private function loop(int $x, int $y): void {
        $queue = new Queue;

        $start = json_encode([$x,$y]);
        $queue->insert($this->newEntry(0, 0, 0, -1, -1, 0, 1, 0), 0);
        $this->grid[$start] = [
            "value" => 0,
            "path" => $start
        ];
        
        $i=0;

        while($queue->isNotEmpty()) {
            echo "<hr>";
            echo "queue size: ". $queue->queueSize() ."<br>";
            ["heatloss" => $heatLoss, "x" => $x, "y" => $y, "prevX" => $prevX, "prevY" => $prevY, "directionX" => $xDirection, "directionY" => $yDirection, "steps" => $steps] = $queue->shift();
            echo "Node: ". $x ." - ". $y ."<br>";

            if ($x === $this->width-1 && $y === $this->height-1) {
                return [$heatLoss];
            }
            
            // been before
            if (isset($this->visited[json_encode([$x, $y, $xDirection, $yDirection, $steps])])) {
                echo "x: ". $x .", y: ". $y .", already visited<br>";
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

                $queue->insert($this->newEntry($newValue, $newX, $newY, $x, $y, $xNewDirection, $yNewDirection, $steps), $newValue);
            }

            print_r($queue->show());
            if($i>10) {
                echo"i-break!!!!";
                break;
            }
            $i++;
        }
    }

    /**
     * @return array<mixed>
     */
    public function getGrid():array {
        return $this->grid;
    }

    public function part1(): int {
        // $this->loop(0,0);
        // $endPoint = json_encode([$this->width-1,$this->height-1]);
        // $endPoint = json_encode([3,1]);
        // print_r($this->grid);
        // echo "final path -->";
        // print_r($this->grid[$endPoint]["path"]);
        [$heatLoss] = $this->loop(0,0);
        // print_r($path);
        return $heatLoss;
    }

    public function part2(): int {
        return 1;
    }
    
}
