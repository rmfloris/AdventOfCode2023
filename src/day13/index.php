<?php
require_once '../autoload.php';

use day13\Day13;

$day = new Day13(true);
// echo "<br>Game Total: #". $day->part1();

echo "<pre>";
echo "<br>: #". $day->part1() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();


