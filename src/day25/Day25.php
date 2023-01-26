<?php

namespace day25;

use common\Day;

class Day25 extends Day {

    /** @var array<mixed> */
    private array $snafu = [
        -2 => "=",
        "-",
        0,
        1,
        2
    ];

    public function part1(): string 
    {
        $sum = 0;
        foreach($this->inputData as $snafu) {
            $sum += $this->snafuToDecimal($snafu);
        }

        return $this->decimalToSnafu($sum);
    }

    public function part2(): int 
    {
        return 0;
    }

    private function snafuToDecimal(string $snafu): int
    {
        $sum = 0;
        $positions = str_split($snafu);
        foreach(array_reverse($positions) as $pos => $digit) {
            $sum += array_flip($this->snafu)[$digit] * pow(5, $pos);
        }
        return $sum;
    }

    private function decimalToSnafu(int $decimal): string
    {
        $snafu = "";
        $rest = 0;
        $carryOver = false;

        while($decimal>0) {
            $rest = $decimal % 5 + (int)$carryOver;
            if($carryOver = ($rest > 2)) $rest -= 5;
            $snafu .= $this->snafu[$rest];
            $decimal = intdiv($decimal, 5);
        }
        return strrev($snafu);
    }
}