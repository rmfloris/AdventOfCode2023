<?php
require_once '../autoload.php';

use day2\Day2;

$day2 = new Day2();
echo "<br>Game Total: #". $day2->part1();
echo "<br>: #". $day2->part2() ."<br>";

echo "memory: ". $day2->getMemoryUsage() ."<br>";
echo "time: ". $day2->getElapsedTime();