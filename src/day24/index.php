<?php
require_once '../autoload.php';
echo "<pre>";

use day24\Day24;

$day = new Day24(true);


echo "<br>: #". $day->part1() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();
