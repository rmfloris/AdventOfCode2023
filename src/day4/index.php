<?php
require_once '../autoload.php';

use day4\Day4;

$day = new Day4(true);
// echo "<br>Game Total: #". $day->part1();
echo "<br>: #". $day->part2() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();