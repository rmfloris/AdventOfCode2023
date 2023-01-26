<?php

namespace day13;

use common\Day;

class Day13 extends Day {

    /** @var array<mixed> */
    private array $inputArray;
    /** @var array<mixed> */
    private array $pairs;

    protected function loadData(): void
    {
        parent::loadData();
        $this->parseData();
    }

    public function part1(): int
    {
        $this->startComparing();
        return $this->getSumOfIndices();
    }

    public function part2(): int
    {
        return 0;
    }

    private function parseData(): void {
        foreach($this->inputData as $line) {
            if(strlen($line > 0)) {
                $this->inputArray[] = json_decode($line);
            }
        }
    }

    /**
     * @return array<mixed>
     */
    public function startComparing(): array {
        $pair = 1;
        for($i=0; $i<count($this->inputArray);$i++) {
            $this->pairs[$pair] = ($this->compareLines($this->inputArray[$i], $this->inputArray[$i+1]) < 1 ? 1 : 0);
            $i++;
            $pair++;
        }
        return $this->pairs;
    }

    public function getSumOfIndices(): int {
        return array_sum(array_keys(array_filter($this->pairs, function($v, $k) {
            return $v > 0;
        }, ARRAY_FILTER_USE_BOTH)));
    }

    /**
     * @return array<mixed>
     */
    public function getPairs(): array {
        return $this->pairs;
    }

    /**
     * @param array<mixed> $line1
     * @param array<mixed> $line2
     */
    private function compareLines(array|int $line1, array|int $line2): int {
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

    /**
     * @param array<mixed> $package
     */
    public function addPackage(array $package): void {
        array_push($this->inputData, $package);
    }
}