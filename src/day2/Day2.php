<?php

namespace day2;

use common\Day;

class Day2 extends Day {

    /** @var array<mixed> */
    private array $moves = [];
    /** @var array<mixed> */
    private array $points = [
        "A" => 1, // Rock
        "B" => 2, // Paper
        "C" => 3,  // Scissors
        "X" => 1, // Rock
        "Y" => 2, // Paper
        "Z" => 3  // Scissors
    ];
    /** @var array<mixed> */
    private array $strategicOutcome = [
        "X" => "lose",
        "Y" => "draw",
        "Z" => "win"
    ];
    /** @var array<mixed> */
    private array $myMoveOptions = [
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
    /** @var array<mixed> */
    private array $pointsResult = [
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

    /**
     * @param array<string> $move
     */
    private function calculateScorePart1(array $move): int {
        $score = 0;
        $score += $this->points[$move["me"]];
        $score += $this->pointsResult[$this->gameResult($move)];
        return $score;
    }

    /**
     * @param array<string> $move
     */
    private function calculateScorePart2(array $move): int {
        $score = 0;
        $myMove = $this->defineMove($move);
        $score += $this->points[$myMove];
        $score += $this->pointsResult[$move["me"]];
        return $score;
    }

    /**
     * @param array<string> $moves
     */
    private function defineMove(array $moves): string {
        if($this->strategicOutcome[$moves["me"]] == "draw") { return $moves["opponent"]; }

        return $this->myMoveOptions[$this->strategicOutcome[$moves["me"]]][$moves["opponent"]];
    }

    /**
     * @param array<string> $move
     */
    private function gameResult(array $move): string {
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

    public function part1(): int
    {
        $score = 0;
        foreach($this->moves as $move) {
            $score += $this->calculateScorePart1($move);
        }
        return $score;
    }

    public function part2(): int
    {
        $score = 0;
        foreach($this->moves as $moves) {
            $score += $this->calculateScorePart2($moves);
        }
        return $score;
    }
}