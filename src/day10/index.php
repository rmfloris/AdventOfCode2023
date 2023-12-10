<?php
require_once '../autoload.php';

use day10\Day10;

$day = new Day10();
// echo "<br>Game Total: #". $day->part1();
echo "<pre>";
echo "<br>: #". $day->part1() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();