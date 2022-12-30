<?php
require_once '../autoload.php';

use day4\Day4;

$numberOfAssignment = new Day4();
echo "Number of overlapping ranges: ". $numberOfAssignment->part1(); 
echo "<br>";
echo "Number of partly overlapping ranges: ". $numberOfAssignment->part2();