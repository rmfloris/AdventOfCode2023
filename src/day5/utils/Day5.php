<?php

namespace day5\utils;
use common\LoadInput;

class Day5 {

    private $inputMoves = array();
    private $inputCrates = array();
    private $cratesPosition = array();

    public function __construct($cratesInputFile, $movesInputFile) {
        $this->inputMoves = $this->parseInput($movesInputFile);
        $this->inputCrates = $this->parseInput($cratesInputFile);

    }

    private function parseInput($inputFile) {
        $data = explode("\n", (new LoadInput)->loadFile($inputFile));
        return $data;
    }

    public function processCrates() {
        foreach($this->inputCrates as $line) {
            $data = explode (" ", $line);
            for($i=1; $i<count($data);$i++) {
                $this->cratesPosition[$data[0]][] = $data[$i];
            }
        }
    }

    public function processMovesWithCrateMover($moverNumber) {
        foreach($this->inputMoves as $move) {
            /**
             * first is # of crates
             * second is from position
             * third is to position
             */
            preg_match('#^\D*(\d*)\D*(\d*)\D*(\d*)#', $move, $movesDetail);

            if($moverNumber == 9000) {
                $this->moveCratesWithCrateMover9000($movesDetail[1], $movesDetail[2], $movesDetail[3]);
            } else {
                $this->moveCratesWithCrateMover9001($movesDetail[1], $movesDetail[2], $movesDetail[3]);
            }
        }
    }

    public function processMovesWithCrateMover9001() {
        foreach($this->inputMoves as $move) {
            preg_match('#^\D*(\d*)\D*(\d*)\D*(\d*)#', $move, $movesDetail);
            // echo "<pre>";
            // var_dump($movesDetail);

            $this->moveCratesWithCrateMover9000($movesDetail[1], $movesDetail[2], $movesDetail[3]);
        }
    }

    private function moveCratesWithCrateMover9000($number, $from, $to) {
        for($i=0; $i<$number; $i++) {
            $crateToMove = array_pop($this->cratesPosition[$from]);
            $this->cratesPosition[$to][] = $crateToMove;
        }
    }

    private function moveCratesWithCrateMover9001($number, $from, $to) {
        $cratesToMove = array_slice($this->cratesPosition[$from], -$number, null, true);
        array_splice($this->cratesPosition[$from], -$number);
        $this->cratesPosition[$to] = array_merge($this->cratesPosition[$to], $cratesToMove);
       
    }

    public function getTopCrates() {
        $listOfTopCrates = "";
        foreach($this->cratesPosition as $cratesPile) {
            $listOfTopCrates .= end($cratesPile);
        }
        return $listOfTopCrates;
    }
}