<?php

namespace day13;

use common\Day;

class Day13 extends Day {

    /** @var array<mixed> */
    private $map = [];
    private int $score = 0;

    protected function loadData(): void
    {
        parent::loadData();
        $i=0;
        foreach($this->inputData as $line) {
            if(strlen($line) === 0){
                $i++;
                continue;
            }
            $this->map[$i][] = str_split($line);
        }
    }

    /**
     * @return array<mixed>
     */
    private function findOptions(string $string) {
        $length = strlen($string);
        $possibilities = [];
        for($i=0;$i<$length-1; $i++) {
            $left = ($i+1);
            $right = $length-$i-1;
            $positions = min($left, $right);
            
            $leftString = substr($string, $i-$positions+1, $positions);
            $rightString = strrev(substr($string, $i+1, $positions));
            if(strcmp($leftString, $rightString) === 0){
                $possibilities[] = $i;
            }
        }
        return $possibilities;
    }

    /**
     * @return array<mixed>
     * @param array<mixed> $map
     */
    private function findOptionsCols($map) {
        $options = [];
        foreach($map as $row) {
            // print_r($row);  
            $options = array_merge($options, $this->findOptions(implode($row)));
        }
        return $options;
    }
    
    /**
     * @return array<mixed>
     * @param array<mixed> $map
     */
    private function findOptionsRows($map) {
        $options = [];
        for($x=0; $x<count($map[0]); $x++) {
            $column = implode(array_column($map, $x));
            $options = array_merge($options, $this->findOptions($column));
        }
        return $options;
    }

    public function part1(): int {
        foreach($this->map as $key => $map) {
            // print_r($map);
            // print_r(array_count_values($this->findOptionsCols($map)));
            $colNumber = array_search(count($map), array_count_values($this->findOptionsCols($map)));
            // print_r(array_count_values($this->findOptionsRows($map)));
            $rowNumber = array_search(count($map[0]), array_count_values($this->findOptionsRows($map)));
            if($colNumber !== false) {
                $this->score += $colNumber+1;
            }
            if($rowNumber !== false) {
                $this->score += ($rowNumber+1)*100;
            }
        }
        return $this->score;
    }

    public function part2(): int {
        return 1;
    }
    
}
