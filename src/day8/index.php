<?php
require_once '../autoload.php';

use day8\utils\Day8;

// $filename = "input/input_test.txt";
$filename = "input/input.txt";

$numberOfTrees = new Day8($filename);
echo "1. Total visible number of trees: ". $numberOfTrees->calculateVisibleTrees() . " (1736)<br>";

echo "2. Highest Scenic Score: ". $numberOfTrees->getHighestScenicScore() . " (268800)";