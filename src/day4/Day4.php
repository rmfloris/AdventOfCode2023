<?php

namespace day4;

use common\Day;

class Day4 extends Day {
    private int $totalPoints = 0;
    /** @var array<int> */
    private $scorePerCard = [];
    /** @var array<int> */
    private $additionalPointsPerCard = [];

    private function calculatePoints(): void {
        foreach($this->inputData as $lineId => $line) {
            preg_match_all("#\d+|\|#", $line, $matches);
            // remove first entry as this is the card number
            array_shift($matches[0]);
            $break = array_search("|", $matches[0]);
            
            $winningNumbers = array_slice($matches[0], 0, $break);
            $cardNumbers = array_slice($matches[0], $break+1, count($matches[0]));

            $numberOfWinningNumbers = count(array_intersect($winningNumbers, $cardNumbers));

            $this->scorePerCard[$lineId] = $numberOfWinningNumbers;

            if($numberOfWinningNumbers === 0) { 
                continue;
            } elseif ($numberOfWinningNumbers === 1) {
                $this->totalPoints += 1;
            } else {
                $this->totalPoints += pow(2, $numberOfWinningNumbers-1);
            }
        }
    }

    private function getNumberOfCards(): void {
        for (end($this->scorePerCard); key($this->scorePerCard)!==null; prev($this->scorePerCard)){
            $cardId = key($this->scorePerCard);
            $score = current($this->scorePerCard);
            
            if($cardId + $score > count($this->scorePerCard)) {
                $score = count($this->scorePerCard) - $cardId;
            }
            $additionalScore = 0;
            
            for($x=1;$x<=$score;$x++) {
                $additionalScore += $this->additionalPointsPerCard[$cardId+$x];
            }
            $this->additionalPointsPerCard[$cardId] = $additionalScore + $score;
        }
    }

    public function part1(): int {
        $this->calculatePoints();
        return $this->totalPoints;
    }

    public function part2(): int {
        $this->calculatePoints();
        $this->getNumberOfCards();
        return array_sum($this->additionalPointsPerCard) + count($this->scorePerCard);
    }
    
}
