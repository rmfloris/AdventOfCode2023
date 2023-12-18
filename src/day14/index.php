<?php
require_once '../autoload.php';

use day14\Day14;

// $day = new Day14(true);
$day = new Day14();
// echo "<br>Game Total: #". $day->part1();

echo "<pre>";
echo "<br>: #". $day->part2() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();

print_r($day->getTableData());

