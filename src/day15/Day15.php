<?php	

namespace day15;

use common\Day;

class Day15 extends Day {	

    private array $map;	
    private array $count = [];	
    private int $xPosition;	

    protected function loadData(): void
    {
        parent::loadData();
        $this->createMap();
    }

    public function part1()
    {
        return $this->getPositionsAt(2000000);
    }

    public function part2()
    {
        return $this->findDistressFrequency(0, 4000000);
    }

    public function fillMap() {	
        foreach($this->sensor as $position => $sensor) {	
            $distance = $sensor["distance"];	
            [$xPos, $yPos] = json_decode($position);	
            // echo $distance;	

            $yCorrection = 0;	
            $max = false;	
            for($x=$xPos-$distance; $x<=$xPos+$distance+1;$x++) {	
                for($y=$yPos-$yCorrection;$y<=$yPos+$yCorrection;$y++) {	
                    $key = $this->getKey($x, $y);	
                    if(!isset($this->map[$key])) {	
                        $this->map[$key] = "#";	
                        (isset($this->count[$y]) ? $this->count[$y] += 1 : $this->count[$y] = 1);	
                    }	
                }	
                ($max ? $yCorrection-- : $yCorrection++);	
                if($yCorrection >= $distance) {	
                    $max = true;	
                }	
            }	
        }	
    }	

    private function createMap() {	
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

    private function calculateDistance($position1, $position2) {	
        [$x1, $y1] = json_decode($position1);	
        [$x2, $y2] = json_decode($position2);	
        return abs($x1 - $x2) + abs($y1 - $y2);	
    }	

    public function printGraph() {	
        $table = "<table>";	
        $table .= "<tr><th></th>";	
        // foreach(range(-2, 25) as $header) {	
        foreach(range(0, 20) as $header) {	
            $table .= "<th>". $header ."</th>";	
        }	
        $table .= "</tr>";	

        // for($y = 0; $y <= 22; $y++) {	
        for($y = 0; $y <= 20; $y++) {	
            $table .= "<tr>";	
            $table .= "<td>". $y ."</td>";	
            // for($x = -2; $x <= 25; $x++) {	
            for($x = 0; $x <= 20; $x++) {	
                $value = $this->map[$this->getKey($x, $y)] ?? ".";	
                $table .= "<td>". $value ."</td>";	
            }	
        }	
        return $table;	
    }	

    private function getKey($x, $y) {	
        return json_encode([(string)$x, (string)$y]);	
    }	

    public function getPositionsAt($row) {	
        return $this->fillRow($row);	
    }	

    private function fillRow(int $row, int $minRange = null, int $maxRange = null, bool $subtractBeacons = true) {	
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
                        $xMin;	
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

    private function getBeaconsAtRow(int $row) {	
        return count(array_keys(array_column($this->beacon, 'y'), $row));	
    }	

    public function findDistressFrequency(int $min, int $max) {	
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
