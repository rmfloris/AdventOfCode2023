<?php

namespace common;

class Shoelace {

    private float $area;

    public function __construct()
    {
        $this->area = 0;
    }

    public function addPoints($x1, $y1, $x2, $y2) {
        $this->area += ($x1 * $y2 - $x2 * $y1)/2;
    }

    public function getAreaSize() {
        return abs($this->area);
    }
}