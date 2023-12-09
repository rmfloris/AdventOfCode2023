<?php

namespace day7;

use common\Day;

class Day7 extends Day {
    /** @var array<mixed> */
    public array $hands = [];
    /** @var array<string | int> */
    private array $cards = ["A", "K", "Q", "J", "T", "9", "8", "7", "6", "5", "4", "3","2"];
    /** @var array<string | int> */
    private array $cardsWithJokerActive = ["A", "K", "Q", "T", "9", "8", "7", "6", "5", "4", "3","2", "J"];
    /** @var array<string | int> */

    private bool $areJokersActive = false;

    private function parseData() {
        foreach($this->inputData as $line) {
            [$hand, $bid] = explode(" ", $line);
            $this->hands[] = [
                "hand"  => $hand,
                "bid"   => $bid,
                "score" => $this->calculateHand($hand)
            ];
        }
    }

    private function calculateHand($hand): int {
        $frequencyPerCard = array_fill_keys($this->cards, 0);
        foreach(str_split($hand) as $card) {
            $frequencyPerCard[$card] += 1;
        }
        return $this->calculateScore($frequencyPerCard);
    }

    private function updateHandForJokers($frequencyPerCard) {
        if($frequencyPerCard["J"] > 0) {
            $numberOfJokers = $frequencyPerCard["J"];
            $isJokerAtFirstPosition = (key($frequencyPerCard) == "J" ? true : false);

            $maxScore = max($frequencyPerCard);
            if($isJokerAtFirstPosition) {
                next($frequencyPerCard);
            } 
            $frequencyPerCard[key($frequencyPerCard)] += $numberOfJokers;
            unset($frequencyPerCard["J"]);
        }
        return $frequencyPerCard;
    }

    private function calculateScore($frequencyPerCard): int {
        arsort($frequencyPerCard);
        $frequencyPerCard = ($this->areJokersActive ? $this->updateHandForJokers($frequencyPerCard) : $frequencyPerCard);
        $maxScore = (max($frequencyPerCard) == 1 ? 0 : max($frequencyPerCard));
        $pointsToAllocate = $maxScore;        

        if($maxScore == 3) {
            // fullhouse
            if(next($frequencyPerCard) == 2) {
                $pointsToAllocate = 3.5; // full house
            } 
        }

        if($maxScore == 2){
            if(next($frequencyPerCard) == 2) {
                $pointsToAllocate = 2;
            } else {
                $pointsToAllocate = 1;
            }
        }
        $pointsToAllocate = $pointsToAllocate * 10;
        return $pointsToAllocate;
    }

    private function customSortHands($a, $b) {
        $cardList = ($this->areJokersActive ? $this->cardsWithJokerActive : $this->cards);
        if($a['score'] == $b['score']) {
            foreach(str_split($a['hand']) as $key => $card) {
                if($card != $b['hand'][$key]) {
                    return (array_search($card, $cardList) > array_search($b['hand'][$key], $cardList)) ? -1 : 1;
                }
            }
            return 0;
        }
        return ($a['score'] < $b['score']) ? -1: 1;
    }

    private function calculateTotalScore(): int {
        usort($this->hands, array($this, "customSortHands"));
        $totalScore = 0;
        foreach($this->hands as $rank => $hand) {
            $totalScore += ($rank+1) * $hand['bid'];
        }

        return $totalScore;
    }

    public function part1(): int {
        $this->parseData();
        return $this->calculateTotalScore();
    }

    public function part2(): int {
        $this->areJokersActive = true;
        $this->parseData();   
        return $this->calculateTotalScore();
    }
    
}
