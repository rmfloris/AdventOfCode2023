<?php	

namespace day15;

use common\Day;

class Day15 extends Day {	

    /** @var array<mixed> */
    private array $map;	
    /** @var array<mixed> */
    private array $beacon;
    /** @var array<mixed> */
    private array $sensor;
    private int $xPosition;	

    protected function loadData(): void
    {
        parent::loadData();
        $this->createMap();
    }

    public function part1(): int
    {
        return $this->getPositionsAt(2000000);
    }

    public function part2(): int
    {
        return $this->findDistressFrequency(0, 4000000);
    }

    private function createMap(): void {	
        foreach($this->inputData as $line) {	
            preg_match_all("#([+-])?(\d+)#", $line, $positions);	

            $keySensor = $this->getKey($positions[0][0], $positions[0][1]);	
            $keyBeacon = $this->getKey($positions[0][2], $positions[0][3]);	
            $this->map[$keySensor] = "S";	
            $this->map[$keyBeacon] = "B";	
            $this->beacon[$keyBeacon] = [	
                "x" => $positions[0][2],	
                "y" => $positions[0][3]	
            ];	
            $this->sensor[$keySensor] = array(	
                "x" => $positions[0][0],	
                "y" => $positions[0][1],	
                "distance" => $this->calculateDistance($keySensor, $keyBeacon),	
                "beacon" => $keyBeacon	
            );	
        }	
    }	

    private function calculateDistance(string $position1, string $position2): int {	
        [$x1, $y1] = json_decode($position1);	
        [$x2, $y2] = json_decode($position2);	
        return abs($x1 - $x2) + abs($y1 - $y2);	
    }	

    private function getKey(string $x, string $y): string {	
        return json_encode([(string)$x, (string)$y]);	
    }	

    public function getPositionsAt(int $row): int {	
        return $this->fillRow($row);	
    }	

    private function fillRow(int $row, int $minRange = null, int $maxRange = null, bool $subtractBeacons = true): int {	
        $score = 0;	

        foreach($this->sensor as $key => $sensorData) {	
            ["x" => $x, "y" => $y, "distance" => $distance] = $sensorData;	

            if($y >= ($row-$distance) && $y <= ($row+$distance) ) {	
                $numberOfYPositions = (($distance - abs($row-$y))*2);	

                // $xMin = $x - $numberOfYPositions/2;	
                // $xMax = $x + $numberOfYPositions/2;	
                ($x - $numberOfYPositions/2 <= $minRange && is_int($minRange) ? $xMin = $minRange : $xMin = $x - $numberOfYPositions/2);	
                ($x + $numberOfYPositions/2 >= $maxRange && is_int($maxRange) ? $xMax = $maxRange : $xMax = $x + $numberOfYPositions/2);	

                $positions[$key] = array(	
                    "xMin" => $xMin,	
                    "xMax" => $xMax,	
                    "x" => $x	
                );	
                // echo $key ." - ". $x ." - ". $y ." - ". $distance ." - " .$numberOfYPositions ." - ". $xMin ." - ". $xMax ."<br>";	
            }	
        }	

        $xMinSort  = array_column($positions, 'xMin');	
        array_multisort($xMinSort, SORT_ASC, $positions);	

        $max = null;	
        $i=0;	

        foreach($positions as $key => $position) {	
            ["xMin" => $xMin, "xMax" => $xMax] = $position;	

            // echo "Key: ". $key ." - ";	

            // correct for 0 in range	
            ($xMin <= 0 && $xMax >= 0 ? $score += 1 : null);	
            if($i == 0) {	
                $min = $xMin;	
                $max = $xMax;	
                $score += $max - $min; // delta	
                $i++;	
            } else {	
                if ($xMin <= $max && $xMax <= $max) {	
                    $xMin = 0;	
                } else {	
                    if($xMin>= $max) {	
                        $this->xPosition = $xMin-1;	
                        // $xMin;	
                    } else {                        	
                        $xMin = $max;	
                    }	
                }	
                ($xMax > $max ? $max = $xMax : $xMax = 0);	
                $score += $xMax - $xMin; // delta	
            }	
            // echo "xMin: ". $xMin ." - xMax: ". $xMax ." - ";	
            // echo "score: ". $score ."<br>";	
        }	
        // exclude beacons	
        if($subtractBeacons) {	
            $score -= $this->getBeaconsAtRow($row);	
            // echo "Beacons to exclude: ". $this->getBeaconsAtRow($row) ."<br>";	
        }	
        // echo "final score: ". $score ."<br>";	
        return $score;	
    }	

    private function getBeaconsAtRow(int $row): int {	
        return count(array_keys(array_column($this->beacon, 'y'), $row));	
    }	

    public function findDistressFrequency(int $min, int $max): string|int {	
        for($y=$min; $y<=$max; $y++) {	
            if($this->fillRow($y, $min, $max, false) < $max-$min+1) {	
                $frequency = ($this->xPosition * 4000000) + $y;	
                // echo "x pos: ". $this->xPosition ." - y pos: ". $y ."<br>";	
                return $frequency;	
            }	
        }	
        return "not found";	
    }	
}	
