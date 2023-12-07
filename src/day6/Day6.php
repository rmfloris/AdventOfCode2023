<?php

namespace day6;

use common\Day;

class Day6 extends Day {
    /** @var array<int> */
    private array $time = [];
    /** @var array<int> */
    private array $distance = [];
    /** @var array<int> */
    private array $winners = [];

    private function parseData(): void {
        preg_match_all("#\d+#", $this->inputData[0], $matches);    
        $this->time = $matches[0];
        $this->winners = array_fill(0,count($matches[0]), 0);

        preg_match_all("#\d+#", $this->inputData[1], $matches);    
        $this->distance = $matches[0];
        
    }

    private function calculateWinners(): void {
        foreach($this->time as $key => $time) {
            for($i=1; $i<$time;$i++) {
                $distance = ($time - $i) * $i;
                if($distance > $this->distance[$key]) {
                    $this->winners[$key] += 1;
                }
            }
        }
    }
    /**
     * @param array<int> $array
     */
    private function mergeArray($array): int {
        $combinedValues = '';
        foreach($array as $value) {
            $combinedValues = $combinedValues . $value;
        }
        return (int) $combinedValues;
    }

    /**
     * @return array<string, int>
     */
    private function getOptions() {
        $time = $this->mergeArray($this->time);
        $distance = $this->mergeArray($this->distance);
        $maxOption = ($time+(sqrt(pow($time,2)-4*$distance)))/2;
        $minOption = ($time-(sqrt(pow($time,2)-4*$distance)))/2;

        return [
            "min" => (int) ceil($minOption),
            "max" => (int) floor($maxOption)
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
