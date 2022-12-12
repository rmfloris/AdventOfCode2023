<?php

namespace day11\utils;
use common\LoadInput;
use ArrayIterator;

class Day11 {

    private array $inputData = [];
    private array $monkeyItems = [];
    private array $monkeyInspections = [];
    private array $monkeyRules = [];
    private int $currentMonkeyId = 0;

    public function __construct($filename) {
        $this->parseInput($filename);
    }

    public function startRounds($numberOfRound=1) {
        echo "<pre>";
        for($round=1;$round<=$numberOfRound;$round++) {
            echo "round: ". $round ."<br>";
            $this->inspectItems($round);

            echo "after round #". $round ." the item list: <br>";
            print_r($this->monkeyItems);
        }
    }

    public function getItemList(){
        return $this->monkeyItems;
    }

    private function inspectItems($round) {
        echo "<pre>";
        reset($this->monkeyItems);
        while($val = current($this->monkeyItems)) {
            $monkeyId = key($this->monkeyItems);
            echo "MonkeyId: ". $monkeyId ."<br>";
            while($item = current($this->monkeyItems[$monkeyId])) {
                $itemId = key($this->monkeyItems[$monkeyId]);
                echo "id: ". $monkeyId ." - ". $item ." - ". $itemId ." - ";
                $this->monkeyInspections[$monkeyId] = +1;

                $worryLevel = $this->applyOperation($monkeyId, $item);
                $worryLevel = $this->getsBored($worryLevel);
                echo $worryLevel ."<br>";
                $this->actOnItem($monkeyId, $itemId, $worryLevel);
                
            }
            next($this->monkeyItems);
        }

        /**
         * foreach doesn't work with updates to array
         */
        // echo "<pre>";
        // foreach($this->monkeyItems as $monkeyId => $items) {
        //     if ( empty($this->monkeyItems[$monkeyId] ) ) {
		// 		continue;
		// 	}
        //     foreach($items as $itemId => $item) {
        //         echo "id: ". $monkeyId ." - ". $item ." - ". $itemId ." - ";
        //         $this->monkeyInspections[$monkeyId] = +1;
        //         $worryLevel = $this->applyOperation($monkeyId, $item);
        //         $worryLevel = $this->getsBored($worryLevel);
        //         echo $worryLevel ."<br>";
        //         $this->actOnItem($monkeyId, $itemId, $worryLevel);
        //     }
        // }
    }

    private function actOnItem($monkeyId, $itemId, $worryLevel) {
        if($worryLevel % $this->monkeyRules[$monkeyId]["test"] == 0) {
            $toMonkey = $this->monkeyRules[$monkeyId]["testTrue"];
            echo "true: to monkey = ". $this->monkeyRules[$monkeyId]["testTrue"] ."<br>";
        } else {
            $toMonkey = $this->monkeyRules[$monkeyId]["testFalse"];
            echo "false: to monkey = ". $this->monkeyRules[$monkeyId]["testFalse"] ."<br>";
        }

        unset($this->monkeyItems[$monkeyId][$itemId]);
        $this->monkeyItems[$toMonkey][] = $worryLevel;
        // echo "<pre>";
        // print_r($this->monkeyItems);
    }

    private function getsBored($value) {
        return floor($value / 3);
    }
    private function applyOperation($monkeyId, $value) {
        $operation = $this->monkeyRules[$monkeyId]["operation"];
        preg_match("/[a-z]+ = ([a-z0-9]+) (.*) ([a-z0-9]+)/", $operation, $matches);

        if($matches[1] == 'old') { $part1 = $value; }
        if($matches[3] == 'old') { $part2 = $value; } else { $part2 = $matches[3]; }

        switch($matches[2]){
            case "+":
                return $part1 + $part2;
                break;
            case "-":
                return $part1 - $part2;
                break;
            case "*":
                return $part1 * $part2;
                break;
            case "/":
                return $part1 / $part2;
                break;
        }
        return 0;
    }

    private function parseInput($filename) {
        $lines = $this->inputData = explode("\n", (new LoadInput)->loadFile($filename));
        foreach($lines as $key => $line) {
            $indent = strspn($line, " ");
            // echo "line ". $key .": ". strspn($line, " ") ." <br>";
            if(strlen($line) > 0) {

                switch($indent) {
                    case 0:
                        // new monkey
                        $monkeyId = substr($line,7,1);
                        $this->monkeyRules[$monkeyId] = [];
                        $this->monkeyItems[$monkeyId] = [];
                        $this->monkeyInspections[$monkeyId] = 0;
                        $this->currentMonkeyId = (int) $monkeyId;
                        break;
                    case 2:
                        // starting items
                        // operation
                        // test
                        $operator = trim(substr($line,0,strpos($line, ":",0)));
                        // echo "op: ". $operator ."<br>";
                        if($operator == 'Starting items') {
                            $items = explode(",", substr($line, strpos($line, ":",0)+1));
                            foreach($items as $item) {
                                $this->addItemToMonkeyNo($this->currentMonkeyId, $item);
                            }
                        }
                        if($operator == 'Operation') {
                            $rule = substr($line, strpos($line, ":",0)+1);
                            $this->monkeyRules[$this->currentMonkeyId]["operation"] = trim($rule);
                        }
                        if($operator == 'Test') {
                            $rule = substr($line, strpos($line, ":",0)+1);
                            $rule = str_replace("divisible by ", "", $rule);
                            $this->monkeyRules[$this->currentMonkeyId]["test"] = trim($rule);
                        }
                        
                        break;
                    case 4:
                        // tests
                        $toMonkey = substr($line, -1);
                        if(strpos($line, "If true")) {
                            $this->monkeyRules[$this->currentMonkeyId]["testTrue"] = trim($toMonkey);
                        } else {
                            $this->monkeyRules[$this->currentMonkeyId]["testFalse"] = trim($toMonkey);
                        }
                        break;
                }
            }
        }
    }

    private function addItemToMonkeyNo($monkeyId, $item) {
        // echo "Add ". $item ." to ". $monkeyId ."<br>";
        $this->monkeyItems[$monkeyId][] = trim($item);
    }

}