<?php
require_once '../autoload.php';
// $filename = "input/input_test.txt";
$filename = "input/input.txt";

use day9\utils\Day9;

$positions = new Day9($filename);
$positions->startMoving();

echo "positions: ". $positions->getNumberOfPositions();

// echo "<pre>";
// var_dump($positions);

