<?php

namespace day13;

use common\Day;

class Day13 extends Day {

    private array $inputArray;
    private array $pairs;

    protected function loadData(): void
    {
        parent::loadData();
        $this->parseData();
    }

    public function part1()
    {
        $this->startComparing();
        return $this->getSumOfIndices();
    }

    public function part2()
    {
        return 0;
    }

    private function parseData() {
        foreach($this->inputData as $line) {
            if(strlen($line > 0)) {
                $this->inputArray[] = json_decode($line);
            }
        }
    }

    public function startComparing() {
        $pair = 1;
        for($i=0; $i<count($this->inputArray);$i++) {
            $this->pairs[$pair] = ($this->compareLines($this->inputArray[$i], $this->inputArray[$i+1]) < 1 ? 1 : 0);
            $i++;
            $pair++;
        }
        return $this->pairs;
    }

    public function getSumOfIndices() {
        return array_sum(array_keys(array_filter($this->pairs, function($v, $k) {
            return $v > 0;
        }, ARRAY_FILTER_USE_BOTH)));
    }

    public function getPairs() {
        return $this->pairs;
    }

    private function compareLines($line1, $line2) {
        if(is_int($line1) && is_int($line2)) {
            return $line1 <=> $line2;
        }

        if(is_int($line1) && is_array($line2)) { $line1 = [$line1]; }
        if(is_int($line2) && is_array($line1)) { $line2 = [$line2]; }

        if(is_array($line1) && is_array($line2)) {
            while(count($line1) && count($line2)) {

                $l = array_shift($line1);
                $r = array_shift($line2);

                if($result = $this->compareLines($l, $r)) return $result;
            }
        }
        return count($line1) - count($line2);
    }

    public function addPackage(array $package) {
        array_push($this->inputData, $package);
    }
}