<?php

namespace day2;

use common\Day;

class Day2 extends Day {

    private $moves = array();
    private $points = [
        "A" => 1, // Rock
        "B" => 2, // Paper
        "C" => 3,  // Scissors
        "X" => 1, // Rock
        "Y" => 2, // Paper
        "Z" => 3  // Scissors
    ];
    private $strategicOutcome = [
        "X" => "lose",
        "Y" => "draw",
        "Z" => "win"
    ];
    private $myMoveOptions = [
        "win" => [
            "A" => "B",
            "B" => "C",
            "C" => "A"
        ],
        "lose" => [
            "A" => "C",
            "B" => "A",
            "C" => "B"
        ]
    ];
    private $pointsResult = [
        "win" => 6,
        "draw" => 3,
        "lose" => 0,
        "X" => 0,
        "Y" => 3,
        "Z" => 6
    ];

    protected function LoadData():void
    {
        parent::loadData();
        $this->loadMoves();
    }

    private function loadMoves(): void
    {
        foreach($this->inputData as $setOfMoves) {
            $movesData = explode(" ", $setOfMoves);
            $this->moves[] = [
                "opponent" => $movesData[0],
                "me" => $movesData[1]
            ];
        }
    }

    private function calculateScorePart1($move) {
        $score = 0;
        $score += $this->points[$move["me"]];
        $score += $this->pointsResult[$this->gameResult($move)];
        return $score;
    }

    private function calculateScorePart2($move) {
        $score = 0;
        $myMove = $this->defineMove($move);
        $score += $this->points[$myMove];
        $score += $this->pointsResult[$move["me"]];
        return $score;
    }

    private function defineMove($moves) {
        if($this->strategicOutcome[$moves["me"]] == "draw") { return $moves["opponent"]; }

        return $this->myMoveOptions[$this->strategicOutcome[$moves["me"]]][$moves["opponent"]];
    }

    private function gameResult($move) {
        /**
         * A Rock
         * B Paper
         * C Scissors
         * X Rock
         * Y Paper
         * Z Scissors
         */
        if($move["opponent"] == "A") {
            if($move["me"] == "Y") {
                return "win";
            }
            if($move["me"] == "X") {
                return "draw";
            }
        }
        if($move["opponent"] == "B") {
            if($move["me"] == "Z") {
                return "win";
            }
            if($move["me"] == "Y") {
                return "draw";
            }
        }
        if($move["opponent"] == "C") {
            if($move["me"] == "X") {
                return "win";
            }
            if($move["me"] == "Z") {
                return "draw";
            }
        }
        return "lose";
    }

    public function part1()
    {
        $score = 0;
        foreach($this->moves as $move) {
            $score += $this->calculateScorePart1($move);
        }
        return $score;
    }

    public function part2()
    {
        $score = 0;
        foreach($this->moves as $moves) {
            $score += $this->calculateScorePart2($moves);
        }
        return $score;
    }
}