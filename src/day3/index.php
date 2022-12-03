<?php

require_once '../autoload.php';

use day3\utils\DuplicateFinder;

// $file = "input/input_test.txt";
$file = "input/input.txt";

$error = new DuplicateFinder($file);
$totalPriorities = $error->calculatePriorities();

echo $totalPriorities;
