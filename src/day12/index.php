<?php
require_once '../autoload.php';

use day12\Day12;

$day = new Day12(true);
// echo "<br>Game Total: #". $day->part1();

echo "<pre>";
echo "<br>: #". $day->part2() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();

