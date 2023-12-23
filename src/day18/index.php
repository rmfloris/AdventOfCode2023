<?php
// ini_set('max_execution_time', '300');
require_once '../autoload.php';

use day18\Day18;

$day = new Day18(true);

echo "<pre>";
echo "<br>: #". $day->part1() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();

echo $day->getTableData();
