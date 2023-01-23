<?php
namespace day5;

use common\Day;

class Day5 extends Day {

    private $inputMoves = array(); 
    private $inputCrates = array();
    private $cratesPosition = array();

    protected function LoadData():void
    {
        parent::loadData();
        $this->inputMoves = $this->inputData;
        $this->inputCrates = $this->getArrayFromInputFile("day5_crates");
    }

    public function part1()
    {
        $this->processCrates();
        $this->processMovesWithCrateMover(9000);
        return $this->getTopCrates();
    }

    public function part2()
    {
        $this->processCrates();
        $this->processMovesWithCrateMover(9001);
        return $this->getTopCrates();
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