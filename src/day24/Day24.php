<?php

namespace day24;

use common\Day;

class Day24 extends Day {
    /** @var array<array{x: int, y: int, z: int}> */
    private array $positions;
    /** @var array<array{x: int, y: int, z: int}> */
    private array $vectors;
    private int $minValue;
    private int $maxValue;

    protected function loadData(): void
    {
        parent::loadData();
        foreach($this->inputData as $row) {
            [$positions, $vectors] = explode("@", $row);
            [$px, $py, $pz] = explode(",", $positions);
            [$vx, $vy, $vz] = explode(",", $vectors);
            $this->positions[] = [
                "x" => $px,
                "y" => $py,
                "z" => $pz
            ];

            $this->vectors[] = [
                "x" => $vx,
                "y" => $vy,
                "z" => $vz
            ];
        }
    }

    private function doIntersect(int $firstHail, int $secondHail): int {
        $positionFirstHail = $this->positions[$firstHail];
        $vectorFirstHail = $this->vectors[$firstHail];
        $positionSecondHail = $this->positions[$secondHail];
        $vectorSecondHail = $this->vectors[$secondHail];

        /**
         * y = xValua * x + bValue
         */
        $xValueFirstHail = (1/$vectorFirstHail["x"] *$vectorFirstHail["y"]); 
        $xValueSecondHail = (1/$vectorSecondHail["x"] *$vectorSecondHail["y"]);
        $bValueFirstHail = ($positionFirstHail["y"]-(($positionFirstHail["x"]/$vectorFirstHail["x"])*$vectorFirstHail["y"]));
        $bValueSecondHail = ($positionSecondHail["y"]-(($positionSecondHail["x"]/$vectorSecondHail["x"])*$vectorSecondHail["y"]));

        $xValue = $xValueSecondHail - $xValueFirstHail;
        $bValue = $bValueFirstHail - $bValueSecondHail;
        if($xValue == 0) return 0;
        
        $xPos = $bValue / $xValue;
        $yPos = $xPos * $xValueFirstHail + $bValueFirstHail;
        
        if($xPos < $this->minValue || $yPos < $this->minValue) return 0;
        if($xPos > $this->maxValue || $yPos > $this->maxValue) return 0;

        if(
            ($positionFirstHail["x"] + $vectorFirstHail["x"] <=> $xPos) != (0 <=> $vectorFirstHail["x"]) ||
            ($positionFirstHail["y"] + $vectorFirstHail["y"] <=> $yPos) != (0 <=> $vectorFirstHail["y"]) ||
            ($positionSecondHail["x"] + $vectorSecondHail["x"] <=> $xPos) != (0 <=> $vectorSecondHail["x"]) ||
            ($positionSecondHail["y"] + $vectorSecondHail["y"] <=> $yPos) != (0 <=> $vectorSecondHail["y"])
            ) {
                return 0;
        }
        return 1;
    }

    public function setBoundries(int $min, int $max): void {
        $this->minValue = $min;
        $this->maxValue = $max;
    }
    
    public function part1(): int {
        $totalIntersects = 0;
        for($i=0; $i<count($this->positions);$i++) {
            for($j=$i+1; $j<count($this->positions);$j++){
                $totalIntersects += $this->doIntersect($i, $j);
            }
        }
        return $totalIntersects;
    }

    public function part2(): int {
        return 1;
    }
    
}
