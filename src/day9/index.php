<?php
require_once '../autoload.php';
$filename_test_part2 = "input/input_test_part2.txt";
$filename = "input/input.txt";

use day9\utils\Day9;

$part2 = new Day9($filename);
$part2->startMoving();
echo "positions: ". $part2->getNumberOfPositions(1) ." (6057)<br>";
echo "positions: ". $part2->getNumberOfPositions(9) ." (2514)<br>";