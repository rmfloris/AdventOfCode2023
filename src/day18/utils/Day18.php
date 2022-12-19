<?php

namespace day18\utils;

use common\LoadInput;


class Day18 {
    private array $inputData;
    private array $grid;
    private int $sidesCount = 0;

    public function __construct($filename)
    {
        $this->inputData = $this->parseData($filename);
        $this->sidesCount = $this->setMaxSides();
        $this->addToGrid();
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
        echo "checking: ". $x ." - ". $y ." - ". $z ."<br>";
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