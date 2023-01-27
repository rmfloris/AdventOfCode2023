<?php
require_once '../autoload.php';

use day22\Day22;

echo "<pre>";

$day = new Day22();
echo "outcome: ". $day->part1() ." \n";
var_dump($day->getVisitedSpots());