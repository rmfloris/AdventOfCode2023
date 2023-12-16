<?php
require_once '../autoload.php';

use day16\Day16;

$day = new Day16(true);
// echo "<br>Game Total: #". $day->part1();

echo "<pre>";
echo "<br>: #". $day->part1() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();

