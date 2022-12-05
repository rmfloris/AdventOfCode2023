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

    public function processMoves() {
        foreach($this->inputMoves as $move) {
            /**
             * first is # of crates
             * second is from position
             * third is to position
             */
            preg_match('#^\D*(\d*)\D*(\d*)\D*(\d*)#', $move, $movesDetail);
            // echo "<pre>";
            // var_dump($movesDetail);

            $this->moveCrates($movesDetail[1], $movesDetail[2], $movesDetail[3]);
            
        }
    }

    private function moveCrates($number, $from, $to) {
        // end($array)
        // move 1 from 2 to 1
        // get last
        // delete last from 2
        // add last to 1

        // $crateToMove = end($this->cratesPosition[$from]);
        // $cratesToMove = array_reverse(array_slice($this->cratesPosition[$from], -$number, null, true), true);
        // $cratesToMove = array_reverse(array_slice($this->cratesPosition[$from], -2, null, true), true);

        for($i=0; $i<$number; $i++) {
            $crateToMove = array_pop($this->cratesPosition[$from]);
            $this->cratesPosition[$to][] = $crateToMove;
        }
    }

    public function getTopCrates() {
        $listOfTopCrates = "";
        foreach($this->cratesPosition as $cratesPile) {
            $listOfTopCrates .= end($cratesPile);
        }
        return $listOfTopCrates;
    }
}