<?php

namespace day12;

use common\Day;
use Error;

class Day12 extends Day {

    /** @var string[][] */
    private $springsInfo = [];
    /** @var int[] */
    private $validOptionsList = [];

    protected function loadData(): void {
        parent::loadData();
        
        foreach($this->inputData as $line) {
            [$map, $counter] = explode(" ", $line);
            $damaged = explode(",", $counter);
            $this->springsInfo[] = [
                "map" => $map,
                "damaged" => $damaged
            ];
        }
    }

    /**
     * @return array<mixed>
     */
    private function findPossibleArrangements(string $springs): array {
        $index = strpos($springs, "?");
        if ($index === false) return [$springs]; 

        return array_merge(
            $this->findPossibleArrangements($this->replaceChar($springs, ".", $index)),
            $this->findPossibleArrangements($this->replaceChar($springs, "#", $index))
        );
    }

    private function replaceChar(string $string, string $replaceValue, int $position):string {
        return substr_replace($string, $replaceValue, $position, 1);
    }

    /**
     * @param array<string> $options
     * @param array<string> $damaged
     */
    private function validateOptions($options, $damaged): void {
        foreach($options as $option) {
            if($this->isValidOption($option, $damaged)) $this->validOptionsList[] = $option;
        }
    }

    /**
    * @param array<string> $damaged
    */
    private function isValidOption(string $option, $damaged): bool {
        $damagedLength = 0;
        $damageOption = 0;
        foreach(str_split($option) as $char) {
            switch($char) {
                case ".":
                    if($damagedLength > 0) {
                        if($damagedLength !== (int) $damaged[$damageOption]) return false;
                        $damagedLength = 0;
                        $damageOption++;
                    }
                    break;
                case "#":
                    $damagedLength++;
                    if($damageOption >= count($damaged) || $damagedLength > $damaged[$damageOption]) return false;

                    break;
                default:
                    throw new Error(" problemss....");
            }
        }
        if(($damagedLength === 0 || $damagedLength === (int) $damaged[$damageOption]) && $damageOption === count($damaged) - ($damagedLength > 0 ? 1 : 0)) return true;
        return false;
    }

    private function solve(): void {
        foreach($this->springsInfo as $springInfo) {
            $options = $this->findPossibleArrangements($springInfo["map"]);
            $this->validateOptions($options, $springInfo["damaged"]);    
        }
    }

    public function part1(): int {
        $this->solve();
        return count($this->validOptionsList);;
    }

    public function part2(): int { 
        foreach($this->springsInfo as $key => $value) {
            $this->springsInfo[$key] = [
                "map" => implode("?", array_fill(0,5, $value["map"])),
                "damaged" => array_merge(...array_fill(0,5, $value["damaged"]))
            ];
        }
        $this->solve();
        return count($this->validOptionsList);;
    }
    
}
