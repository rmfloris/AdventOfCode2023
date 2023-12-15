<?php
require_once '../autoload.php';

use day14\Day14;

$day = new Day14(true);
// echo "<br>Game Total: #". $day->part1();

echo "<pre>";
echo "<br>: #". $day->part1() ."<br>";
echo "<br>";
echo "memory: ". $day->getMemoryUsage() ."<br>";
echo "time: ". $day->getElapsedTime();

$data = $day->getTableData();

echo "<table border='1' style='border-collapse: collapse;'>";
echo "<th>";
for($i=0; $i<count($data[0]); $i++) {
    echo "<td>". $i ."</td>";
}
echo "</th>";
foreach($data as $key => $row) {
    echo "<tr>";
    echo "<td>". $key ."</td>";
    for($i=0; $i<count($data[0]); $i++) {
        echo "<td>". $row[$i] ."</td>";
    }
    echo "</tr>";
}