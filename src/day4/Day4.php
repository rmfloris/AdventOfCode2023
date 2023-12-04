<?php

namespace day4;

use common\Day;

class Day4 extends Day {

    private int $totalPoints = 0;
    private $scorePerCard = [];
    private int $totalCards = 0;

    private function calculatePoints(): void {
        foreach($this->inputData as $lineId => $line) {
            preg_match_all("#\d+|\|#", $line, $matches);
            // remove first entry as this is the card number
            array_shift($matches[0]);
            $break = array_search("|", $matches[0]);
            
            $winningNumbers = array_slice($matches[0], 0, $break);
            $cardNumbers = array_slice($matches[0], $break+1, count($matches[0]));

            $numberOfWinningNumbers = count(array_intersect($winningNumbers, $cardNumbers));

            $this->scorePerCard[] = [
                "cardNo" => $lineId,
                "score" => $numberOfWinningNumbers
            ];

            if($numberOfWinningNumbers === 0) { 
                continue;
            } elseif ($numberOfWinningNumbers === 1) {
                
                $this->totalPoints += 1;
            } else {
                $this->totalPoints += pow(2, $numberOfWinningNumbers-1);
            }
        }
    }

    private function getNumberOfCards() {
        while(count($this->scorePerCard) > 0) {
            $this->totalCards += 1;

            // add new cards to the list
            $cardNo = current($this->scorePerCard)["cardNo"];
            $score = current($this->scorePerCard)["score"];

            echo $cardNo ." - ". $score ."<br>";
            if($score !== 0) {
                echo "adding<br>";
            }
            
            // remove current card from list
            array_shift($this->scorePerCard);
        }
        return 1;
    }

    public function part1(): int {
        $this->calculatePoints();
        return $this->totalPoints;
    }

    public function part2(): int {
        $this->calculatePoints();
        $this->getNumberOfCards();
        return 1;
    }
    
}
