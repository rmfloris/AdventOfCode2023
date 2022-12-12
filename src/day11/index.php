<?php
require_once '../autoload.php';
$filename = "input/input_test.txt";
// $filename = "input/input_test_large.txt";
// $filename = "input/input.txt";

use day11\utils\Day11;

$monkeys = new Day11($filename);
$monkeys->startRounds(3);

// print_r($monkeys->getItemList() );

// echo "<Pre>";
// var_dump($monkeys);