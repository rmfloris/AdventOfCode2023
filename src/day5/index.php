<?php
require_once '../autoload.php';

use day5\Day5;

$moves = "input/input_moves.txt";
$crates = "input/input_crates.txt";

$crateStack = new Day5();
echo "List of top Crates for part 1: ". $crateStack->part1() ."<p>";

// reset to the start
echo "List of top Crates for part 2: ". $crateStack->part2() ."<p>";