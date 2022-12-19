<?php

namespace day18\utils;

use common\LoadInput;


class Day18 {
    private array $inputData;
    private array $grid;
    private array $max;
    private int $sidesCount = 0;

    public function __construct($filename)
    {
        $this->inputData = $this->parseData($filename);
        $this->sidesCount = $this->setMaxSides();
        $this->addToGrid();
    }

    public function preparePart2() {
        $this->setMaxBoundries();
        $this->findAir();
    }

    private function findAir() {
        $start = $this->getKey(0,0,0);
        $queue[] = array($start);
        $surface = 0;

        while(count($queue)) {
            $droplet = array_shift($queue);
            [$x, $y, $z] = json_decode($droplet[0]);
           
            if(isset($visited[$droplet[0]])) continue;
            if($x < -1 || $y < -1 || $z < -1) continue;
            if($x > $this->max["x"]+1 || $y > $this->max["y"]+1 || $z > $this->max["z"]+1) continue;
            if(isset($this->grid[$this->getKey($x, $y,$z)])) continue;
            $visited[$droplet[0]] = 1;


            $surface += $this->checkFaces($x, $y, $z) / -2;
            $this->sidesCount += $this->isAir($x, $y, $z);

            $queue[] = [$this->getKey($x+1, $y,   $z)];
            $queue[] = [$this->getKey($x-1, $y,   $z)];
            $queue[] = [$this->getKey($x,   $y+1, $z)];
            $queue[] = [$this->getKey($x,   $y-1, $z)];
            $queue[] = [$this->getKey($x,   $y,   $z+1)];
            $queue[] = [$this->getKey($x,   $y,   $z-1)];
            // $i++;
        }
        // print_r($this->max);
        // echo "i: ". $i ."<br>";
        echo $surface;

    }

    private function isAir($x, $y, $z) {
        if(isset($this->grid[$this->getKey($x, $y, $z)])) return 0;
        if($this->checkFaces($x, $y, $z) == -12) {
            echo $x ."-". $y ."-".$z." is air<br>";
            return -6;
        }
        return 0;
    }

    private function setMaxBoundries() {
        $this->max = [
            "x" => max(array_column($this->grid, "x")),
            "y" => max(array_column($this->grid, "y")),
            "z" => max(array_column($this->grid, "z"))
        ];
    }

    private function parseData($filename) {
        return (new LoadInput)->loadFileToLines($filename);
    }

    public function getSides() {
        return $this->sidesCount;
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