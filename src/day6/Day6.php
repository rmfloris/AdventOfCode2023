<?php

namespace day6;

use common\Day;

class Day6 extends Day {

    private array $time = [];
    private array $distance = [];
    private array $winners = [];

    private function parseData() {
        preg_match_all("#\d+#", $this->inputData[0], $matches);    
        $this->time = $matches[0];
        $this->winners = array_fill(0,count($matches[0]), 0);

        preg_match_all("#\d+#", $this->inputData[1], $matches);    
        $this->distance = $matches[0];
        
    }

    private function calculateWinners() {
        foreach($this->time as $key => $time) {
            for($i=1; $i<$time;$i++) {
                $distance = ($time - $i) * $i;
                if($distance > $this->distance[$key]) {
                    $this->winners[$key] += 1;
                }
            }
        }
    }

    private function mergeArray($array) {
        $string = '';
        foreach($array as $value) {
            $string = $string . $value;
        }
        return $string;
    }

    private function getOptions() {
        $time = $this->mergeArray($this->time);
        $distance = $this->mergeArray($this->distance);
        $maxOption = ($time+(sqrt(pow($time,2)-4*$distance)))/2;
        $minOption = ($time-(sqrt(pow($time,2)-4*$distance)))/2;

        return [
            "min" => ceil($minOption),
            "max" => floor($maxOption)
        ];
    }

    public function part1(): int {
        $this->parseData();
        $this->calculateWinners();
        return array_product($this->winners);
    }

    public function part2(): int {
        $this->parseData();
        $options = $this->getOptions();

        return $options["max"] - $options["min"] +1 ;
    }
    
}
