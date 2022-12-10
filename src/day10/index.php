<?php
require_once '../autoload.php';
$filename = "input/input_test.txt";
$filename = "input/input_test_large.txt";
$filename = "input/input.txt";

use day10\utils\Day10;

$computer = new Day10($filename);
$computer->startProgram();

echo "1.Total signal strenght: " . $computer->getSignalStrength() ." (14780)<br>";

echo "<pre>";
var_dump($computer);
