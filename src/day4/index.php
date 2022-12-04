<?php
require_once '../autoload.php';

use day4\utils\Day4;

// $file = "input/input_test.txt";
$file = "input/input.txt";

$numberOfAssignment = new Day4($file);
echo "Number of overlapping ranges: ". $numberOfAssignment->findNumberOfFullyOverlappingRange(); 
echo "<br>";
echo "Number of partly overlapping ranges: ". $numberOfAssignment->findNumberOfPartylOverlappingRange();