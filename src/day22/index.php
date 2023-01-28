<?php
require_once '../autoload.php';

use day22\Day22;

echo "<pre>";

$day = new Day22();
echo "outcome: ". $day->part1() ." \n";
// var_dump($day->getVisitedSpots());

$moves = [
    "steps"=> [
        26
    ],
    "turns" => [
        "R"
    ]
];  

$currentPosition = [
    "x" => 116,
    "y" => 47
];

$day->setDebugMode();
$day->setData(1, $moves, $currentPosition);
$day->startMoving();
echo "<p>";
var_dump($day->getData());


