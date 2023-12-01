<?php
require_once '../autoload.php';

use day1\Day1;

$finder = new Day1();
echo "<br>Total number is: #". $finder->part1();
echo "<br>: #". $finder->part2() ."<br>";

echo "memory: ". $finder->getMemoryUsage() ."<br>";
echo "time: ". $finder->getElapsedTime();