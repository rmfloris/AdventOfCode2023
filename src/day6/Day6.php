<?php

namespace day6;
use common\Day;

class Day6 extends Day {
    private int $numberOfCharactersForMarker = 0;

    public function part1(): int
    {
        $this->setNumberOfCharactersForMarker(4);
        return $this->findStartOfPacketMarker();
    }

    public function part2(): int
    {
        $this->setNumberOfCharactersForMarker(14);
        return $this->findStartOfPacketMarker();
    }

    public function setNumberOfCharactersForMarker(int $number): void {
        $this->numberOfCharactersForMarker = $number;
    }

    public function findStartOfPacketMarker(): int {
        $i=0;
        $letters = str_split($this->inputData[0]);
        foreach($letters as $letter) {
            if($i >= $this->numberOfCharactersForMarker) {
                if(count(array_unique(array_slice($letters, $i-$this->numberOfCharactersForMarker, $this->numberOfCharactersForMarker))) == $this->numberOfCharactersForMarker) { return $i; }
            }
            $i++;
        }
        return 0;
    }
}