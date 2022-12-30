<?php
require_once '../autoload.php';
// error_reporting(E_ALL & ~E_WARNING);

use day12\Day12;
$path = new Day12();

echo "Minimal number of steps part 1: ". $path->part1() ." answer: 440<br>";
echo "Minimal number of steps part 2: ". $path->part2() ." answer: 439";