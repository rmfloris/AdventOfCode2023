<?php

namespace day6\utils;
use common\LoadInput;

class Day6 {
    private $inputString = "";
    private $inputArray = [];
    private $numberOfCharactersForMarker = 0;

    public function __construct($inputFile) {
        $this->inputArray = str_split((new LoadInput)->loadFile($inputFile));
    }

    public function setNumberOfCharactersForMarker($number) {
        $this->numberOfCharactersForMarker = $number;
    }

    public function findStartOfPacketMarker() {
        $i=0;
        foreach($this->inputArray as $letter) {
            if($i >= $this->numberOfCharactersForMarker) {
                if(count(array_unique(array_slice($this->inputArray, $i-$this->numberOfCharactersForMarker, $this->numberOfCharactersForMarker))) == $this->numberOfCharactersForMarker) { return $i; }
            }
            $i++;
        }
    }
}