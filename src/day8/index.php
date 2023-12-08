<?php
require_once '../autoload.php';

use day8\Day8;

$day = new Day8();
// echo "<br>Game Total: #". $day->part1();
echo "<pre>";
echo "<br>: #". $day->part2() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();