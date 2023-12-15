<?php

namespace day14;

use common\Day;
use common\Helper;

class Day14 extends Day {
    /** @var array<mixed> */
    private $map = [];

    protected function loadData(): void
    {
        parent::loadData();
        foreach($this->inputData as $line) {
            $this->map[] = str_split($line);
        }
    }

    /**
     * @param array<mixed> $column
     * */
    private function getMinPosition($column, string $char, int $y): int {
        $hits = array_filter($column, function($value, $position) use($y, $char) {
            return $value === $char && $position < $y;
        }, ARRAY_FILTER_USE_BOTH);
        if(empty($hits)) {
            // echo "empty " .$char ."\n";
            return -1;
        }
        return max(array_keys($hits));
    }



    private function tiltSouth() {
        foreach($this->map as $y => $mapRow) {
            foreach($this->map[$y] as $x => $position) {
                if($y === 0) continue;
                if($position !== "O") continue;

                // echo "x: ". $x ."\n";

                $column = array_column($this->map, $x);
 
                $otherBoulders = $this->getMinPosition($column, "O", $y);
                $rocks = $this->getMinPosition($column, "#", $y);

                $newPosition = max($otherBoulders, $rocks)+1;
                // echo "rocks: ". $rocks ." - other: ". $otherBoulders ." - newpos: ". $newPosition ."\n";
                // echo "x: ". $x ." -> new: ". $newPosition ."\n";
                if($y !== $newPosition) {
                    $this->map[$newPosition][$x] = "O";
                    $this->map[$y][$x] = ".";
                }
            }
        }
    }

    private function calculateLoad(): int {
        $distanceToSouth = count($this->map);
        $totalValue = 0;
        foreach($this->map as $row) {
            $numberOfRocks = count(array_filter($row, fn($value) => $value === "O"));
            $totalValue += $numberOfRocks * $distanceToSouth;
            $distanceToSouth--;
        }
        return $totalValue;
    }

    public function getTableData() {
        return Helper::showDataAsTable($this->map);
    }

    public function part1(): int {
        $this->tiltSouth();
        return $this->calculateLoad();
    }

    public function part2(): int {
        return 1;
    }
    
}
