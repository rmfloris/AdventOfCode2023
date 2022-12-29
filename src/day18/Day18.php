<?php

namespace day18;
use common\Day;

class Day18 extends Day {
    private array $grid;
    private array $max;
    private int $sidesCount = 0;
    private int $surfaceCount = 0;

    protected function loadData(): void
    {
        parent::loadData();
        $this->sidesCount = $this->setMaxSides();
        $this->addToGrid();
    }

    public function preparePart2() {
        $this->setMaxBoundries();
        $this->findSurface();
        return $this;
    }

    private function findSurface() {
        $start = $this->getKey(0,0,0);
        $queue[] = array($start);

        while(count($queue)) {
            $droplet = array_shift($queue);
            [$x, $y, $z] = json_decode($droplet[0]);
           
            if(isset($visited[$droplet[0]])) continue;
            if($x < -1 || $y < -1 || $z < -1) continue;
            if($x > $this->max["x"]+1 || $y > $this->max["y"]+1 || $z > $this->max["z"]+1) continue;
            if(isset($this->grid[$this->getKey($x, $y,$z)])) continue;
            $visited[$droplet[0]] = 1;

            $this->surfaceCount += $this->checkFaces($x, $y, $z) / -2;

            $queue[] = [$this->getKey($x+1, $y,   $z)];
            $queue[] = [$this->getKey($x-1, $y,   $z)];
            $queue[] = [$this->getKey($x,   $y+1, $z)];
            $queue[] = [$this->getKey($x,   $y-1, $z)];
            $queue[] = [$this->getKey($x,   $y,   $z+1)];
            $queue[] = [$this->getKey($x,   $y,   $z-1)];
        }
    }

    private function setMaxBoundries() {
        $this->max = [
            "x" => max(array_column($this->grid, "x")),
            "y" => max(array_column($this->grid, "y")),
            "z" => max(array_column($this->grid, "z"))
        ];
    }

    public function getSides() {
        return $this->sidesCount;
    }

    public function getSurfaceCount() {
        return $this->surfaceCount;
    }

    private function setMaxSides() {
        return count($this->inputData) * 6;
    }

    private function addToGrid() {
        foreach($this->inputData as $coords) {
            [$x, $y, $z] = explode(",", $coords);

            $this->grid[$this->getKey($x, $y, $z)] = [
                "x" => $x,
                "y" => $y,
                "z" => $z
            ];

            $this->sidesCount += $this->checkFaces($x, $y, $z);
        }
    }

    private function checkFaces(int $x, int $y, int $z) :int {
        $substraction = 0;
        // check left
        // echo "checking: ". $x ." - ". $y ." - ". $z ."<br>";
        if(isset($this->grid[$this->getKey($x-1, $y, $z)])) {
            // echo "found on the left<br>";
            $substraction -= 2;
        }
        // check right
        if(isset($this->grid[$this->getKey($x+1, $y, $z)])) {
            // echo "found on the right<br>";
            $substraction -= 2;
        }
        // check above
        if(isset($this->grid[$this->getKey($x, $y+1, $z)])) {
            // echo "found on top<br>";
            $substraction -= 2;
        }
        // check below
        if(isset($this->grid[$this->getKey($x, $y-1, $z)])) {
            // echo "found below<br>";
            $substraction -= 2;
        }
        // check behind
        if(isset($this->grid[$this->getKey($x, $y, $z+1)])) {
            // echo "found behind<br>";
            $substraction -= 2;
        }
        // check front
        if(isset($this->grid[$this->getKey($x, $y, $z-1)])) {
            // echo "found in front<br>";
            $substraction -= 2;
        }

        return $substraction;
    }

    private function getKey(int $x, int $y, int $z) {
        return json_encode([$x, $y, $z]);
    }


}