<?php

require_once '../autoload.php';

use day3\utils\DuplicateFinder;

// $file = "input/input_test.txt";
$file = "input/input.txt";

$error = new DuplicateFinder($file);
echo "Score part 1: ". $error->calculatePriorities() ."<br>";
echo "Score part 2: ". $error->getPriorityByBadge() ."<br>";
/**
 * part 2
 * group lines by 3
 * find letter in all three of them
 */