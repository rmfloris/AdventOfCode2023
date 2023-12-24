<?php
require_once '../autoload.php';
echo "<pre>";

use day19\Day19;

$day = new Day19(true);


echo "<br>: #". $day->part1() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();
