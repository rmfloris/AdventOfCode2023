<?php
require_once '../autoload.php';

use day8\Day8;

$numberOfTrees = new Day8();
echo "1. Total visible number of trees: ". $numberOfTrees->part1() . " (1736)<br>";

echo "2. Highest Scenic Score: ". $numberOfTrees->part2() . " (268800)";