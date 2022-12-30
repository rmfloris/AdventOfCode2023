<?php

require_once '../autoload.php';

use day2\Day2;

$score = new Day2();
echo $score->part1() ."<br>";
echo $score->part2();

echo "memory: ". $score->getMemoryUsage() ."<br>";
echo "time: ". $score->getElapsedTime();

