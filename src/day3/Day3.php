<?php
namespace day3;

use common\Day;

class Day3 extends Day {

    /** @var array<mixed> */
    private array $rucksackContent;
    /** @var array<mixed> */
    private array $badges;
    /** @var array<mixed> */
    private array $duplicates;

    protected function LoadData():void
    {
        parent::loadData();
        $this->loadRucksack();
    }
    
    public function part1(): int
    {
        return $this->calculatePriorities();
    }

    public function part2(): int
    {
        return $this->getPriorityByBadge();
    }

    private function loadRucksack(): void {
        foreach($this->inputData as $rucksack) {
            $this->rucksackContent[] = array(
                substr($rucksack, 0, (strlen($rucksack)/2)),
                substr($rucksack, (strlen($rucksack)/2), strlen($rucksack))
            );
        }
    }

    public function getPriorityByBadge(): int {
        $this->findBadgeLetter();
        return $this->calculate($this->badges);
    }

    private function findBadgeLetter(): void {
        $i=0;
        while($i < count($this->inputData)-2) {
            $rucksack1 = str_split($this->inputData[$i]);
            $rucksack2 = str_split($this->inputData[$i+1]);
            $rucksack3 = str_split($this->inputData[$i+2]);

            foreach(array_unique($rucksack1) as $letter) {
                if(array_search($letter, $rucksack2) !== false && array_search($letter, $rucksack3) !== false) {
                    $this->badges[] = $letter;
                }
            }
            $i += 3;
        }
    }

    public function calculatePriorities(): int {
        $this->findDuplicateCharacters();
        return $this->calculate($this->duplicates);
    }

    /**
     * @param array<string> $duplicates
     */
    private function calculate(array $duplicates): int {
        $score = 0;
        foreach($duplicates as $duplicate) {
            $score += $this->letterToPoints($duplicate);
        }
        return $score;
    }

    /**
     * @return array<mixed>
     */
    public function showDuplicates(): array {
        return $this->duplicates;
    }

    private function letterToPoints(string $letter): int {
        $listOfPoints = array_merge(range('a', 'z'), range('A', 'Z'));

        return array_search($letter, $listOfPoints)+1;
    }

    private function findDuplicateCharacters(): void {
        foreach($this->rucksackContent as $key => $compartments) {
            $compartment1 = str_split($compartments[0]);
            $compartment2 = str_split($compartments[1]);
            foreach(array_unique($compartment1) as $content) {
                if(array_search($content, $compartment2) !== false) {
                    $this->duplicates[] = $content;
                }
            }
        }
    }
}