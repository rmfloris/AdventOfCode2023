<?php
require_once '../autoload.php';

use day7\Day7;

$day = new Day7(true);
// echo "<br>Game Total: #". $day->part1();
echo "<pre>";
echo "<br>: #". $day->part2() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();

// print_r($hands);
echo "<table border='1'>";
echo "<th>";
echo "<td>Hand</td>";
echo "<td>bid</td>";
echo "<td>score</td>";
echo "</th>";
foreach($day->hands as $key => $hand) {
    echo "<tr>";
    echo "<td>". $key ."</td>";
    echo "<td>". $hand['hand'] ."</td>";
    echo "<td>". $hand['bid'] ."</td>";
    echo "<td>". $hand['score'] ."</td>";
    echo "</tr>";
}