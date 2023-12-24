<?php

namespace common;

class Shoelace {

    private float $area;

    public function __construct()
    {
        $this->area = 0;
    }

    public function addPoints(int $x1, int $y1, int $x2, int $y2):void {
        $this->area += ($x1 * $y2 - $x2 * $y1)/2;
    }

    public function getAreaSize(): float {
        return abs($this->area);
    }
}