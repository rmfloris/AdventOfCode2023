<?php
require_once '../autoload.php';
use day18\Day18;

echo "<pre>";
$dice = new Day18();

echo "Number of visible sides: ". $dice->part1() ." (3522)<br>";

echo "Number of visible sides: ". $dice->part2() ." (2074)<br>";
