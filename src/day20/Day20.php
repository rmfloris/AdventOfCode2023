<?php

namespace day20;

use common\Day;

class Day20 extends Day {
    /** @var array<mixed> */
    private array $original;
    private int $decriptionKey = 811589153;
    private int $inputLength = 0;

    protected function LoadData(): void
    {
        parent::loadData();
        foreach($this->inputData as $key => $value) {
            $this->original[] = [
                "index" => $key,
                "movement" => $value
            ];
        }
        $this->inputLength = count($this->inputData);
    }

    public function applyDecriptionKey(): object {
        $originalNew = [];
        foreach($this->original as $original) {
            $originalNew[] = [
                "index" => $original["index"],
                "movement" => $original["movement"] * $this->decriptionKey
            ];
        }
        $this->original = $originalNew;
        return $this;
    }
    public function part1(): int
    {
        return $this->startMoving();
    }

    public function part2(): int
    {
        $this->applyDecriptionKey();
        return $this->startMoving(10);
    }

    private function startMoving(int $number = 1): int {
        $data = $this->startMixing($number);

        $zeroIndex = $this->findZeroIndex($data);
        $index = ($zeroIndex + 1000) % $this->inputLength;

        $answer = 0;
        foreach([1000,2000,3000] as $offset) {
            $index = ($zeroIndex + $offset) % $this->inputLength;
            $answer += $data[$index]["movement"];
        }

        return $answer;
    }

    /**
     * @param array<mixed> $dataArray
     */
    private function findZeroIndex($dataArray): int {
        $index = null;
        foreach($dataArray as $index => $data){
            if($data["movement"] == 0){
                break;
            }
        }
        return $index;
    }

    /**
     * @return array<mixed>
     */
    private function startMixing(int $number): array {
        $data = $this->original;
        for($i=0; $i<$number;$i++) {
            foreach($this->original as $original) {
                $position = array_search($original, $data);
                $value = $data[$position];
                
                $newPosition = ($position + $original["movement"]) % ($this->inputLength-1);

                unset($data[$position]);
                array_splice($data, $newPosition, 0, [$value]);
            }
        }
        return $data;
    }
}