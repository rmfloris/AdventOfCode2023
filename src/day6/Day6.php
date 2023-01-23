<?php

namespace day6;
use common\Day;

class Day6 extends Day {
    private $numberOfCharactersForMarker = 0;

    public function part1()
    {
        $this->setNumberOfCharactersForMarker(4);
        return $this->findStartOfPacketMarker();
    }

    public function part2()
    {
        $this->setNumberOfCharactersForMarker(14);
        return $this->findStartOfPacketMarker();
    }

    public function setNumberOfCharactersForMarker($number) {
        $this->numberOfCharactersForMarker = $number;
    }

    public function findStartOfPacketMarker() {
        $i=0;
        $letters = str_split($this->inputData[0]);
        foreach($letters as $letter) {
            if($i >= $this->numberOfCharactersForMarker) {
                if(count(array_unique(array_slice($letters, $i-$this->numberOfCharactersForMarker, $this->numberOfCharactersForMarker))) == $this->numberOfCharactersForMarker) { return $i; }
            }
            $i++;
        }
    }
}