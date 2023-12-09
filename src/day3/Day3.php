<?php

namespace day3;

use common\Day;
use common\Helper;

class Day3 extends Day {
    /** @var array<string> */
    private array $symbols;
    /** @var array<mixed> */
    private array $symbolLocations = [];
    /** @var array<mixed> */
    private array $numberLocations =[];
    /** @var array<int> */
    private array $touchingNumbers = [];
    private string $gear = "*";
    /** @var array<mixed> */
    private array $gears = [];
    /** @var array<int> */
    private array $gearRatios = [];

    private function getSymbols(): void {
        $inputDataAsString = file_get_contents(parent::getInputFilename());

        preg_match_all("#([^.0-9\s])#", $inputDataAsString, $matches);
        $this->symbols = array_unique($matches[0]);
    }

    private function getSymbolLocations(): void {
        foreach($this->inputData as $lineNumber => $line) {
            for($i=0; $i<strlen($line); $i++) {
                if(array_search($line[$i], $this->symbols) !== false) {
                    $this->symbolLocations[Helper::getKey($i,$lineNumber)] = [
                        "x" => $i,
                        "y" => $lineNumber,
                        "symbol" => $line[$i]
                    ];
                }
            }
        }
    }

    private function getNumberLocations():void {
        foreach($this->inputData as $lineNumber => $line) {
            preg_match_all("#(\d+)#", $line, $matches, PREG_OFFSET_CAPTURE);

            foreach($matches[0] as $foundNumber) {
                $this->numberLocations[] = [
                    "x" => $foundNumber[1],
                    "y" => $lineNumber,
                    "value" => $foundNumber[0]
                ];
            }
        }
    }

    private function findTouchingNumbers(): void {
        foreach ($this->numberLocations as $numberInfo) {
            $xValue = $numberInfo["x"];
            $yValue = $numberInfo["y"];

            $xRange = range($xValue-1, $xValue+strlen((string)$numberInfo["value"]));
            $yRange = range($yValue-1, $yValue+1);
        
            foreach($yRange as $y) {
                foreach($xRange as $x) {
                    if(isset($this->symbolLocations[Helper::getKey($x,$y)])) {
                        $this->touchingNumbers[] = $numberInfo["value"];
                        if($this->symbolLocations[Helper::getKey($x,$y)]["symbol"] === $this->gear) {
                            $this->gears[Helper::getKey($x,$y)][$numberInfo["value"]] = $numberInfo["value"]; 
                        }
                    }
                }
            }
        }
    }

    private function getGearConnections(): void {
        foreach ($this->gears as $gearConnections) {
            if(count($gearConnections) == 2) {
                $this->gearRatios[] = current($gearConnections) * end($gearConnections);
            }
        }
    }

    public function part1(): int {
        $this->getSymbols();
        $this->getSymbolLocations();
        $this->getNumberLocations();
        $this->findTouchingNumbers();

        return array_sum($this->touchingNumbers);
    }

    public function part2(): int {
        $this->getSymbols();
        $this->getSymbolLocations();
        $this->getNumberLocations();
        $this->findTouchingNumbers();
        $this->findTouchingNumbers();
        $this->getGearConnections();

        return array_sum($this->gearRatios);
    }
    
}
