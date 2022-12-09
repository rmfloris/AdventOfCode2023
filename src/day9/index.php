<?php
require_once '../autoload.php';
// $filename = "input/input_test.txt";
$filename = "input/input.txt";

use day9\utils\Day9;
use day9\utils\Day9Part2;

$positions = new Day9($filename);
$positions->startMoving();

echo "positions: ". $positions->getNumberOfPositions() ."<br>";

$part2 = new Day9Part2($filename);
$part2->startMoving();
echo "positions: ". $part2->getNumberOfPositions(1) ."<br>";


// echo "<br><pre>";
// var_dump($part2);

