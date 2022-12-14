<?php

namespace day14\utils;
use common\LoadInput;

class Day14 {

    private array $inputData;
    private array $graph;
    private array $borders = array(
        "minX" => "500",
        "maxX" => "500",
        "minY" => "0",
        "maxY" => "0"
    );
    private int $score = 0;

    public function __construct($filename) {
        $this->inputData = $this->parseData($filename);
    }

    public function dropSandUnits(int $numberOfUnits) {
        for($i=1; $i<=$numberOfUnits;$i++) {
            $this->dropSand();
        }
        return $this->score;
    }

    public function dropSandUnits1() {
        while($this->dropSand()) {
            // echo "dropping<br>";
        }
        return $this->score;
    }

    private function dropSand() {
        $score = 0 ;
        $sandX = 500;
        $sandY = 0;

        while(1) {
            // fill the graph with air
            $downKey = $this->getKey($sandX, $sandY+1);
            $leftKey = $this->getKey($sandX-1, $sandY+1);
            $rightKey = $this->getKey($sandX+1, $sandY+1);

            if(
                $sandX-1 < $this->borders["minX"] ||
                $sandX+1 > $this->borders["maxX"]
            ) return false;

            $down = isset($this->graph[$downKey]) ? $this->graph[$downKey] : ".";
            $leftDown = isset($this->graph[$leftKey]) ? $this->graph[$leftKey] : ".";
            $rightDown = isset($this->graph[$rightKey]) ? $this->graph[$rightKey] : ".";

            if($down != "." && $leftDown != "." && $rightDown != ".") {
                $this->graph[$this->getKey($sandX, $sandY)] = "o";
                $this->score++;
                return true;
            }

            // down
            if($down == ".") {
                $sandY++;
            } else {
                if($leftDown == ".") {
                    $sandX--;
                    $sandY++;
                } elseif ($rightDown == ".") {
                    $sandX++;
                    $sandY++;
                }
            }
            /**
             * over left min or right min -> stop
             */
        }
        return $score;
    }

    private function parseData($filename){
        $lines = (new LoadInput)->loadFileToLines($filename);
        foreach($lines as $line) {
            $positions = explode(" -> ", $line);

            list($startX, $startY) = explode(",", $positions[0]);
            $this->setMinMax($startX, $startY);
            for($i=1; $i<count($positions); $i++) {
                list($x, $y) = explode(",", $positions[$i]);
                $this->setMinMax($x, $y);

                // echo "sx: ". $startX ." sy: ". $startY ."<br>";
                // echo "x: ". $x ." y: ". $y ."<br>";
                
                if($x == $startX) {
                    // go vertical
                    // echo "vertical<br>";
                    $direction = ($y > $startY ? 1 : -1);
                    for($j=$startY;$j!=$y;$j=$j+$direction){
                        $this->graph[$this->getKey($startX, $j)] = "#";
                    }
                }

                if($y == $startY) {
                    // go horizontal
                    // echo "horizontal<br>";
                    $direction = ($x > $startX ? 1 : -1);
                    for($j=$startX;$j!=$x;$j=$j+$direction){
                        $this->graph[$this->getKey($j, $startY)] = "#";
                    }
                }

                $this->graph[$this->getKey($x, $y)] = "#";

                $startX = $x;
                $startY = $y;
            }
        }
        return $lines;
    }

    private function setMinMax($x, $y) {
        if($x < $this->borders["minX"]) { $this->borders["minX"] = $x; }
        if($x > $this->borders["maxX"]) { $this->borders["maxX"] = $x; }
        if($y < $this->borders["minY"]) { $this->borders["minY"] = $y; }
        if($y > $this->borders["maxY"]) { $this->borders["maxY"] = $y; }
    }

    public function printGraph() {
        $table = "<table>";
        $table .= "<tr><th>";
        foreach(range($this->borders["minX"], $this->borders["maxX"]) as $header) {
            $table .= "<td>". $header ."</td>";
        }
        $table .= "</th></tr>";
        
        for($y = $this->borders["minY"]; $y <= $this->borders["maxY"]; $y++) {
            $table .= "<tr>";
            $table .= "<td>". $y ."</td>";
            for($x = $this->borders["minX"]; $x <= $this->borders["maxX"]; $x++) {
                $value = $this->graph[$this->getKey($x, $y)] ?? ".";
                $table .= "<td>". $value ."</td>";
            }
        }
        return $table;
    }

    private function getKey($x, $y) {
        return json_encode([(string)$x, (string)$y]);
    }
}