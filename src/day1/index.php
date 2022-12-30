<?php
require_once '../autoload.php';

use day1\Day1;

$finder = new Day1();
echo "<br>Most calories carried are: #". $finder->part1();
echo "<br>Top 3 have a total calories of: #". $finder->setNumberOfPositions(3)->part2() ."<br>";

echo "memory: ". $finder->getMemoryUsage() ."<br>";
echo "time: ". $finder->getElapsedTime();