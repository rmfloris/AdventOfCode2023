<?php

namespace day12\utils;
use common\LoadInput;

class Day12 {

    private array $inputData;
    private array $graph;
    private array $stepGraph;
    private string $startKey;
    private string $endKey;
    private array $actionKey;

    public function __construct($filename) {
        $this->inputData = $this->parseData($filename);
        $this->buildGraph();
    }

    private function parseData($filename) {
        $lines = (new LoadInput)->loadFileToLines($filename);
        foreach($lines as $key => $line) {
            $data[$key] = str_split($line);
        }
        return $data;
    }

    private function buildGraph() {
        $width = count($this->inputData[0]);
        $height = count($this->inputData);
        for($y=0; $y < count($this->inputData); $y++) {
            for($x=0; $x < $width; $x++) {
                $key = json_encode([$x, $y]);
                $value = $this->getValue($x, $y);
                $this->graph[$key] = $value;
                
                // right
                if($x < $width-1 && $this->hasHigherValue($value, $this->getValue($x+1, $y))) {
                    $this->stepGraph[$key][] = json_encode([$x+1, $y]);
                }
                // left
                if($x > 0 && $this->hasHigherValue($value, $this->getValue($x-1, $y))) {
                    $this->stepGraph[$key][] = json_encode([$x-1, $y]);
                }
                // up
                if($y > 0 && $this->hasHigherValue($value, $this->getValue($x, $y-1))) {
                    $this->stepGraph[$key][] = json_encode([$x, $y-1]);
                }
                // down
                if($y < $height-1 && $this->hasHigherValue($value, $this->getValue($x, $y+1))) {
                    $this->stepGraph[$key][] = json_encode([$x, $y+1]);
                }
            }
        }
    }

    private function hasHigherValue($currentValue, $valueToCheck) {
        return ord($valueToCheck) - ord($currentValue) <= 1;
    }

    private function getValue($x, $y){
        $value = $this->inputData[$y][$x];
        if($value == "S") {
            $this->startKey = json_encode([$x, $y]);
            $this->actionKey[json_encode([$x, $y])] = 1;
            return "a";
        }
        elseif($value == "E") {
            $this->endKey = json_encode([$x, $y]);
            return "z";
        }
        elseif ($value == 'a') {
            $this->actionKey[json_encode([$x,$y])] = 1;
        }

        return $value;
    }

    public function answerPart1() {
        return count($this->findPath($this->startKey))-1;
    }

    public function answerPart2() {
        $routes = [];
        foreach($this->actionKey as $start => $value) {
            if($path = $this->findPath($start)) {
                $routes[$start] = $path;
            };
        }
        asort($routes);
        return count($routes[array_key_first($routes)])-1;
    }

    private function findPath($start) {
        $queue[] = array($start);
        $visited[$start] = 0;

        while(count($queue)) {
	        $path = current($queue);
            array_shift($queue);

	        $node = $path[count($path)-1];
            if($node === $this->endKey) return $path;

            foreach($this->stepGraph[$node] as $option) {
                if(!isset($visited[$option])) {
                    $visited[$option] = 1;
                    $tempPath = $path;
                    $tempPath[] = $option;
                    $queue[] = $tempPath;
                }
            }
        }
        return [];
    }
}