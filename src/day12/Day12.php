<?php

namespace day12;

use common\Day;

class Day12 extends Day{

    /** @var array<mixed> */
    private array $inputArray;
    /** @var array<mixed> */
    private array $graph;
    /** @var array<mixed> */
    private array $stepGraph;
    private string $startKey;
    private string $endKey;
    /** @var array<mixed> */
    private array $actionKey;

    protected function loadData(): void
    {
        parent::loadData();
        $this->parseData();
        $this->buildGraph();
    }

    public function part1(): int
    {
        return count($this->findPath($this->startKey))-1;
    }

    public function part2(): int
    {
        $routes = [];
        foreach($this->actionKey as $start => $value) {
            if($path = $this->findPath($start)) {
                $routes[$start] = $path;
            };
        }
        asort($routes);
        return count($routes[array_key_first($routes)])-1;
    }

    private function parseData(): void {
        foreach($this->inputData as $key => $line) {
            $this->inputArray[$key] = str_split($line);
        }
    }

    private function buildGraph(): void{
        $width = count($this->inputArray[0]);
        $height = count($this->inputArray);
        for($y=0; $y < count($this->inputArray); $y++) {
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

    private function hasHigherValue(int|string $currentValue, int|string $valueToCheck): bool {
        return ord($valueToCheck) - ord($currentValue) <= 1;
    }

    private function getValue(string|int $x, string|int $y): string{
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

    /**
     * @return array<mixed>
     */
    private function findPath(string $start): array {
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