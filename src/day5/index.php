<?php
require_once '../autoload.php';

use day5\utils\Day5;

$moves = "input/input_moves_test.txt";
$crates = "input/input_crates_test.txt";
$moves = "input/input_moves.txt";
$crates = "input/input_crates.txt";

$crateStack = new Day5($crates, $moves);
$crateStack->processCrates();
$crateStack->processMoves();
echo "List of top Crates: ". $crateStack->getTopCrates() ."<p>";


echo "<pre>";
var_dump($crateStack);