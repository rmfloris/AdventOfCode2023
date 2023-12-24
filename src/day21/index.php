<?php
require_once '../autoload.php';
echo "<pre>";

use day21\Day21;

$day = new Day21(true);


echo "<br>: #". $day->part1() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();
