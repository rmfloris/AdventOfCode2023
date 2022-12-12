<?php
require_once '../autoload.php';
$filename = "input/input_test.txt";
// $filename = "input/input_test_large.txt";
// $filename = "input/input.txt";

use day11\utils\Day11;

$monkeys = new Day11($filename);
$monkeys->startRounds(20);
echo "Score for round 1: ". $monkeys->getScore() ." (117624)";

$monkeys2 = new Day11($filename);
$monkeys2->startRounds(1000);
echo "Score for round 2: ". $monkeys2->getScore() ." (???)";
