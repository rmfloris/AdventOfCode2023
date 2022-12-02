<?php

namespace day2\utils;

class ScoreCalculator {

    private $moves = array();
    private $inputData = array();
    private $points = [
        "X" => 1, // Rock
        "Y" => 2, // Paper
        "Z" => 3 // Scissors
    ];
    private $pointsResult = [
        "win" => 6,
        "draw" => 3,
        "lose" => 0
    ];

    public function __construct($inputfile) {
        $this->inputData = $this->parseInput($inputfile);
    }

    private function parseinput($inputfile) {
        $this->inputData = explode("\n", $this->loadFile($inputfile));

        foreach($this->inputData as $setOfMoves) {
            $movesData = explode(" ", $setOfMoves);
            $this->moves[] = [
                "opponent" => $movesData[0],
                "me" => $movesData[1]
            ];
        }
    }

    public function calculateResult() {
        $score = 0;
        foreach($this->moves as $moves) {
            $score += $this->calculateScore($moves);
        }
        return $score;
    }

    private function calculateScore($moves) {
        $score = 0;
        $score += $this->points[$moves["me"]];
        $score += $this->pointsResult[$this->gameResult($moves)];
        return $score;
    }

    private function gameResult($moves) {
        /**
         * A Rock
         * B Paper
         * C Scissors
         * X Rock
         * Y Paper
         * Z Scissors
         */
        if($moves["opponent"] == "A") {
            if($moves["me"] == "Y") {
                return "win";
            }
            if($moves["me"] == "X") {
                return "draw";
            }
        }
        if($moves["opponent"] == "B") {
            if($moves["me"] == "Z") {
                return "win";
            }
            if($moves["me"] == "Y") {
                return "draw";
            }
        }
        if($moves["opponent"] == "C") {
            if($moves["me"] == "X") {
                return "win";
            }
            if($moves["me"] == "Z") {
                return "draw";
            }
        }
        return "lose";
    }

    private function loadFile($filename) {
        $file = fopen($filename, "r") or die("Unable to open file!");
        $data = fread($file,filesize($filename));
        fclose($file);

        return $data;
    }
}