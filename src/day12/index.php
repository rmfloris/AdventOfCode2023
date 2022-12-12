<?php
require_once '../autoload.php';
error_reporting(E_ALL & ~E_WARNING);

$filename = "input/input_test.txt";
$filename = "input/input.txt";

use day12\utils\Day12;
$path = new Day12($filename);

echo "Minimal number of steps part 1: ". $path->answerPart1() ." answer: 440<br>";
echo "Minimal number of steps part 2: ". $path->answerPart2() ." answer: 439";