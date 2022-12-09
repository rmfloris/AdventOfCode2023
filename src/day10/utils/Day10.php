<?php

namespace day10\utils;
use common\LoadInput;

class Day10 {
    private $inputArray = [];

    public function __construct($filename) {
        $this->inputArray = $this->parseInput($filename);
    }

    private function parseInput($inputFile) {
        return explode("\n", (new LoadInput)->loadFile($inputFile));
    }

}