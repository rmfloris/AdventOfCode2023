<?php
ini_set('max_execution_time', '300');
require_once '../autoload.php';

use day17\Day17;

$day = new Day17(true);

echo "<pre>";
echo "<br>: #". $day->part2() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();
