<?php

namespace day15\utils;
use common\LoadInput;

class Day15 {

    private array $inputData;
    private array $map;
    private array $count = [];

    public function __construct($filename) {
        $this->inputData = $this->parseData($filename);
        $this->createMap();
    }

    private function parseData($filename) {
        return (new LoadInput)->loadFileToLines($filename);
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
        foreach(range(-2, 25) as $header) {
        // foreach(range(0, 20) as $header) {
            $table .= "<th>". $header ."</th>";
        }
        $table .= "</tr>";
        
        for($y = 0; $y <= 22; $y++) {
        // for($y = 0; $y <= 20; $y++) {
            $table .= "<tr>";
            $table .= "<td>". $y ."</td>";
            for($x = -2; $x <= 25; $x++) {
            // for($x = 0; $x <= 20; $x++) {
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

    private function fillRow($row) {
        $score = 0;

        foreach($this->sensor as $key => $sensorData) {
            ["x" => $x, "y" => $y, "distance" => $distance] = $sensorData;

            if($y >= ($row-$distance) && $y <= ($row+$distance) ) {
                $numberOfYPositions = (($distance - abs($row-$y))*2);

                $xMin = $x - $numberOfYPositions/2;
                $xMax = $x + $numberOfYPositions/2;

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

            echo "Key: ". $key ." - ";
            
            // correct for 0 in range
            ($xMin <= 0 && $xMax >= 0 ? $score += 1 : null);
            if($i == 0) {
                $min = $xMin;
                $max = $xMax;
                $score += $max - $min; // delta
                $i++;
            } else {
                ($xMin <= $max && $xMax <= $max ? $xMin = 0 : $xMin = $max);
                ($xMax > $max ? $max = $xMax : $xMax = 0);
                $score += $xMax - $xMin; // delta
            }
            echo "xMin: ". $xMin ." - xMax: ". $xMax ." - ";
            echo "score: ". $score ."<br>";
        }
        // exclude beacons
        $score -= $this->getBeaconsAtRow($row);
        echo "Beacons to exclude: ". $this->getBeaconsAtRow($row) ."<br>";
        // echo "final score: ". $score ."<br>";
        return $score;
    }

    private function getBeaconsAtRow(int $row) {
        return count(array_keys(array_column($this->beacon, 'y'), $row));
    }

    public function findDistress(int $min, int $max) {
        // for($y=$min; $y<=$max; $y++) {
        //     echo "Row: ". $y ." -> ". $this->fillRowRange($y, $min, $max) ."<br>";
        // }
        echo $this->fillRowRange(2, $min, $max);
    }

    private function fillRowRange($row, $minRange, $maxRange) {
        $score = 0;

        foreach($this->sensor as $key => $sensorData) {
            ["x" => $x, "y" => $y, "distance" => $distance] = $sensorData;

            if($y >= ($row-$distance) && $y <= ($row+$distance) ) {
                $numberOfYPositions = (($distance - abs($row-$y))*2);

                $xMin = ($x - $numberOfYPositions/2 <= $minRange ? $minRange : $x - $numberOfYPositions/2);
                $xMax = ($x + $numberOfYPositions/2 >= $maxRange ? $maxRange : $x + $numberOfYPositions/2);

                $positions[$key] = array(
                    "xMin" => $xMin,
                    "xMax" => $xMax,
                    "x" => $x
                );

                echo $key ." - ". $x ." - ". $y ." - ". $distance ." - " .$numberOfYPositions ." - ". $xMin ." - ". $xMax ."<br>";
            }
        }
        
        $xMinSort  = array_column($positions, 'xMin');
        array_multisort($xMinSort, SORT_ASC, $positions);

        $min = null;
        $max = null;
        $i=0;

        foreach($positions as $key => $position) {
            ["xMin" => $xMin, "xMax" => $xMax, "x" => $x] = $position;

            echo "Key: ". $key ." - ";
            if($i == 0) {
                $min = $xMin;
                $max = $xMax;
                echo "xmin: ". $xMin . " - xMax: ". $xMax ." ";
                $score += ($max - $min)+1; // delta
                $i++;
            } else {
                echo "xmin: ". $xMin . "(". $min .") - xMax: ". $xMax ."(".$max .") ";
                if($xMin < $max && $xMax > $max) {
                    $xMin = $max+1;
                } elseif($xMin == $max) {
                    $xMin += 1;
                } else {
                    $xMin = 0;
                }
                $min = $xMin;

                if($x > $max) {
                    $score += 1;
                }
                ($xMax > $max ? $max = $xMax : $xMax = 0);
                $score += $xMax - $xMin; // delta
            }
            echo "score: ". $score ."<br>";
        }
        return $score;
    }
}