<?php

namespace day16;

use common\Day;
use common\Helper;

class Day16 extends Day {

    /** @var array<mixed> */
    private $map = [];
    /** @var array<mixed> */
    private $visitedTiles = [];
    /** @var array<mixed> */
    private $stack = [];
    private int $maxScore = 0;

    protected function loadData(): void
    {
        parent::loadData();
        foreach($this->inputData as $line) {
            $this->map[] = str_split($line);
        }
    }

    /**
     * @return array<mixed>
     */
    private function newPosition(int $x, int $y, string $direction): array {
        $newPosition = match($direction) {
            ">" => [$x+1, $y],
            "<" => [$x-1, $y],
            "^" => [$x, $y-1],
            "v" => [$x, $y+1],
            default => [$x, $y]
        };
        return $newPosition;
    }

    private function nextMoves(int $x, int $y, string $direction): void {
        $tile = $this->map[$y][$x];

        if($tile === "|" && ($direction === ">" || $direction === "<")) {
            $this->nextMoves($x, $y, "^");
            $direction = "v";
        }
        if($tile === "-" && ($direction === "^" || $direction === "v")) {
            $this->nextMoves($x, $y, "<");
            $direction = ">";
        }
        if($tile === "/") {
            $direction = match($direction) {
                ">" => "^",
                "<" => "v",
                "^" => ">",
                "v" => "<"
            };
        }
        if($tile === "\\") {
            $direction = match($direction) {
                ">" => "v",
                "<" => "^",
                "^" => "<",
                "v" => ">"
            };
        }

        [$xNew, $yNew] = $this->newPosition($x, $y, $direction);
        $this->addToStack($xNew, $yNew, $direction);
    }

    private function addToStack(int $x, int $y, string $direction): void {
        if($x <0 || $y < 0 || $x >= count($this->map[0]) || $y >= count($this->map)) return;
        if(isset($this->visitedTiles[Helper::getKey($x, $y)][$direction])) return;

        $this->stack[] = [
            "x"=>$x,
            "y"=>$y,
            "direction"=>$direction
        ];
    }

    private function followTheLight(int $x, int $y, string $direction): void {
        $this->addToStack($x,$y,$direction);

        while($this->stack) {
            ["x" => $x, "y" => $y, "direction" => $direction] = array_shift($this->stack); 
            $this->visitedTiles[Helper::getKey($x, $y)][$direction] = 1;
            $this->nextMoves($x, $y, $direction);
        }
    }

    public function part1(): int {
        $this->followTheLight(0,0,">");
        return count($this->visitedTiles);
    }

    public function part2(): int {
        $options = [];
        $height = count($this->map);
        $width = count($this->map[0]);
        for($y=0;$y<$height; $y++) {
            $options[] = [0, $y,">"];
            $options[] = [$width-1,$y,"<"];
        }

        for($x=0;$x<$width;$x++) {
            $options[] = [$x,0,"v"];
            $options[] = [$x,$height-1,"^"];
        }

        while($options) {
            [$x, $y, $direction] = array_shift($options); 
            $this->followTheLight($x, $y, $direction);
            if(count($this->visitedTiles) > $this->maxScore) {
                $this->maxScore = count($this->visitedTiles);
            }
            $this->visitedTiles = [];
        }
       
        return $this->maxScore;
    }
    
}
