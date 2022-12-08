<?php
require_once '../autoload.php';

use day8\utils\Day8;

// $filename = "input/input_test.txt";
$filename = "input/input.txt";

$numberOfTrees = new Day8($filename);
// echo "<pre>";
// var_dump($numberOfTrees);
echo "1. Total visible number of trees: ". $numberOfTrees->calculateVisibleTrees() . " (1736)";
/**
 * Viewing range
 * - All on the outside will score 0, so no total due to multiplier
 * - for the inside
 *  - if vertically / horizontally a higher number is availble
 * 
 * loop through line of array
 * check if max value in other lines are present
 */