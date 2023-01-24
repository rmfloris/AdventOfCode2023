<?php
namespace day5;

use common\Day;

class Day5 extends Day {

    /** @var array<mixed> */
    private array $inputMoves; 
    /** @var array<mixed> */
    private array $inputCrates;
    /** @var array<mixed> */
    private array $cratesPosition;

    protected function LoadData():void
    {
        parent::loadData();
        $this->inputMoves = $this->inputData;
        $this->inputCrates = $this->getArrayFromInputFile("day5_crates");
    }

    public function part1(): string
    {
        $this->processCrates();
        $this->processMovesWithCrateMover(9000);
        return $this->getTopCrates();
    }

    public function part2(): string
    {
        $this->processCrates();
        $this->processMovesWithCrateMover(9001);
        return $this->getTopCrates();
    }

    public function processCrates(): void {
        foreach($this->inputCrates as $line) {
            $data = explode (" ", $line);
            for($i=1; $i<count($data);$i++) {
                $this->cratesPosition[$data[0]][] = $data[$i];
            }
        }
    }

    public function processMovesWithCrateMover(int $moverNumber): void {
        foreach($this->inputMoves as $move) {
            preg_match('#^\D*(\d*)\D*(\d*)\D*(\d*)#', $move, $movesDetail);

            if($moverNumber == 9000) {
                $this->moveCratesWithCrateMover9000($movesDetail[1], $movesDetail[2], $movesDetail[3]);
            } else {
                $this->moveCratesWithCrateMover9001((int) $movesDetail[1], $movesDetail[2], $movesDetail[3]);
            }
        }
    }

    public function processMovesWithCrateMover9001(): void {
        foreach($this->inputMoves as $move) {
            preg_match('#^\D*(\d*)\D*(\d*)\D*(\d*)#', $move, $movesDetail);
            $this->moveCratesWithCrateMover9000($movesDetail[1], $movesDetail[2], $movesDetail[3]);
        }
    }

    private function moveCratesWithCrateMover9000(string $number, string $from, string $to): void {
        for($i=0; $i<$number; $i++) {
            $crateToMove = array_pop($this->cratesPosition[$from]);
            $this->cratesPosition[$to][] = $crateToMove;
        }
    }

    private function moveCratesWithCrateMover9001(int $number, string $from, string $to):void {
        $cratesToMove = array_slice($this->cratesPosition[$from], -$number, null, true);
        array_splice($this->cratesPosition[$from], -$number);
        $this->cratesPosition[$to] = array_merge($this->cratesPosition[$to], $cratesToMove);

    }

    public function getTopCrates(): string {
        $listOfTopCrates = "";
        foreach($this->cratesPosition as $cratesPile) {
            $listOfTopCrates .= end($cratesPile);
        }
        return $listOfTopCrates;
    }
}