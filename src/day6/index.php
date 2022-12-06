<?php
require_once '../autoload.php';

use day6\utils\Day6;

// $filename = "input/input_test.txt";
$filename = "input/input.txt";

$marker = new Day6($filename);

/**
 * part 1
 */
$marker->setNumberOfCharactersForMarker(4);
$position = $marker->findStartOfPacketMarker();

echo "Solution for part 1: ". $position;
echo "<br>";

/**
 * part 2
 */
$marker->setNumberOfCharactersForMarker(14);
$position = $marker->findStartOfPacketMarker();

echo "Solution for part 2: ". $position;
