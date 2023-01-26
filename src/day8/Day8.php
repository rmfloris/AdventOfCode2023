<?php

namespace day8;

use common\Day;

class Day8 extends Day{

    /** @var array<mixed> */
    private array $inputArray = [];

    protected function loadData(): void 
    {
        parent::loadData();
        $this->inputArray = $this->parseInput();
    }

    public function part1(): int
    {
        return $this->calculateVisibleTrees();
    }

    public function part2(): int
    {
        return $this->getHighestScenicScore();
    }

    /**
     * @return array<mixed>
     */

    private function parseInput(): array {
        $data = [];
        foreach($this->inputData as $key => $details) {
            foreach(str_split($details) as $cell) {
                $data[$key][] = $cell;
            }
        }
        return $data;
    }

    public function calculateVisibleTrees(): int {
        $number = 0;
        $number += $this->treesOnEdges();
        $number += $this->treesOnInside();
        return $number;
    }

    private function treesOnEdges(): int {
        return count($this->inputArray)*2 + count($this->inputArray[0])*2 - 4;
    }

    private function treesOnInside():int {
        $number = 0;

        for($x=1; $x<count($this->inputArray)-1;$x++) {
            /**
             * x = row
             * y = columns
             */

            for($y=1; $y<count($this->inputArray[$x])-1;$y++) {
                $number += ($this->isVisibleHorizontally($x, $y) || $this->isVisibileVertically($x, $y) ? 1 : 0);
            }
        }
        return $number;
    }

    private function isVisibleHorizontally(int $row, int $column): bool {
        $rowData = $this->getRowData($row);
        $maxTreesOnLeft = max($this->getTreesBefore($column, $rowData));
        $maxTreesOnRight = max($this->getTreesAfter($column, $rowData));

         return ($this->inputArray[$row][$column] > $maxTreesOnLeft || $this->inputArray[$row][$column] > $maxTreesOnRight);
    }

    private function isVisibileVertically(int $row, int $column): bool {
        $columnData = $this->getColumnData($column);

        $maxTreesOnTop = max($this->getTreesBefore($row, $columnData));
        $maxTreesOnBottom = max($this->getTreesAfter($row, $columnData));
        return ($this->inputArray[$row][$column] > $maxTreesOnTop || $this->inputArray[$row][$column] > $maxTreesOnBottom);
    }

    public function getHighestScenicScore():int {
        return $this->scenicScoreForTreesOnInside();
    }

    private function scenicScoreForTreesOnInside(): int {
        $highestScore = 0;

        for($x=1; $x<count($this->inputArray)-1;$x++) {
            /**
             * x = row
             * y = columns
             */
            for($y=1; $y<count($this->inputArray[$x])-1;$y++) {
                $score = $this->getScoreForTree($x, $y);
                $highestScore = ($score > $highestScore ? $score : $highestScore);
            }
        }
        return $highestScore;
    }

    private function getScoreForTree(int $row, int $column): int {
        $rowData = $this->getRowData($row);
        $columnData = $this->getColumnData($column);

        $treesToTheLeft = $this->getTreesBefore($column, $rowData);
        $treesToTheRight = $this->getTreesAfter($column, $rowData);
        $treesToTheTop = $this->getTreesBefore($row, $columnData);
        $treesToTheBottom = $this->getTreesAfter($row, $columnData);

        $score = $this->getScore($treesToTheTop, $this->inputArray[$row][$column], true) * 
                    $this->getScore($treesToTheLeft, $this->inputArray[$row][$column], true) *
                    $this->getScore($treesToTheRight, $this->inputArray[$row][$column]) * 
                    $this->getScore($treesToTheBottom, $this->inputArray[$row][$column]);

        return $score;        
    }
    
    /**
    * @param array<int> $treeline
    */
    private function getScore(array $treeline, int $currentTree, bool $flip = false): int {
        $treeline = ($flip ? array_reverse($treeline) : $treeline);
        $score = 0;

        foreach($treeline as $tree) {
            if($tree < $currentTree) {
                $score += 1;
            }
            if($tree >= $currentTree) {
                $score += 1;
                break;
            }
        }
        return $score;
    }

    /**
    * @return array<mixed> 
    */
    private function getColumnData(int $column): array {
        return array_column($this->inputArray, $column);
    }

    /**
    * @return array<mixed> 
    */
    private function getRowData(int $row): array {
        return $this->inputArray[$row];
    }
    
    /**
    * @param array<int> $trees
    * @return array<mixed> 
    */
    private function getTreesBefore(int $position, array $trees): array {
        return array_slice($trees,0,$position);
    }

    /**
    * @param array<int> $trees
    * @return array<mixed> 
    */
    private function getTreesAfter(int $position, array $trees): array {
        return array_slice($trees,$position+1);
    }
}