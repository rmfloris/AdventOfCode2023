<?php
require_once '../autoload.php';

use day10\Day10;

$day = new Day10(true);
// echo "<br>Game Total: #". $day->part1();
echo "<pre>";
echo "<br>: #". $day->part2() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();