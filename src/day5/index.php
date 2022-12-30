<?php
require_once '../autoload.php';

use day5\Day5;

$moves = "input/input_moves.txt";
$crates = "input/input_crates.txt";

$crateStack = new Day5($crates, $moves);
$crateStack->processCrates();
$crateStack->processMovesWithCrateMover(9000);
echo "List of top Crates for part 1: ". $crateStack->getTopCrates() ."<p>";

// reset to the start
$crateStack->processCrates();
$crateStack->processMovesWithCrateMover(9001);
echo "List of top Crates for part 2: ". $crateStack->getTopCrates() ."<p>";