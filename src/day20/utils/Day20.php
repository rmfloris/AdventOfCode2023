<?php

namespace day20\utils;

use common\LoadInput;

class Day20 {
    private array $inputData;
    private array $original;
    private int $decriptionKey = 811589153;
    private int $inputLength = 0;

    public function __construct($filename)
    {
        $this->inputData = $this->parseData($filename);
        foreach($this->inputData as $key => $value) {
            $this->original[] = [
                "index" => $key,
                "movement" => $value
            ];
        }
        $this->inputLength = count($this->inputData);
    }

    private function parseData($filename) {
        return (new LoadInput)->loadFileToLines($filename);
    }

    public function applyDecriptionKey() {
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
        // print_r($data);

        $zeroIndex = $this->findZeroIndex($data);
        // echo "zero: ". $zeroIndex ."<br>";
        $index = ($zeroIndex + 1000) % $this->inputLength;
        // echo "index: ". $index ."<br>";
        // echo $data[$index]["movement"];

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