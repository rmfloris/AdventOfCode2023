<?php
require_once '../autoload.php';

use day22\Day22;

echo "<pre>";

$day = new Day22();
// echo "outcome: ". $day->part1() ." \n";
// var_dump($day->getVisitedSpots());

$moves = [
    "steps"=> [
        10
    ],
    "turns" => [
        "L"
    ]
];  

$currentPosition = [
    "x" => 47,
    "y" => 194
];

$day->setDebugMode();
$day->setData(0, $moves, $currentPosition);
$day->startMoving();
echo "<p>";
var_dump($day->getData());


