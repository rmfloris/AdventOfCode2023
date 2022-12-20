<?php

namespace day20;

use common\Day;

class Day20 extends Day {
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

    public function applyDecriptionKey(): void {
        foreach($this->original as $original) {
            $originalNew[] = [
                "index" => $original["index"],
                "movement" => $original["movement"] * $this->decriptionKey
            ];
        }
        $this->original = $originalNew;
    }

    public function startMoving($number = 1) {
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

    private function findZeroIndex($dataArray) {
        $index = null;
        foreach($dataArray as $index => $data){
            if($data["movement"] == 0){
                break;
            }
        }
        return $index;
    }

    private function startMixing($number) {
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