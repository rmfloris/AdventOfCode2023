<?php
require_once '../autoload.php';

use day22\Day22;

echo "<pre>";

$day = new Day22();
// echo "outcome: ". $day->part1() ." \n";
$moves = [
    "steps"=> [
        50
    ],
    "turns" => [
        "L"
    ]
];  

$currentPosition = [
    "x" => 50,
    "y" => 0
];

$day->setData(0, $moves, $currentPosition);
$day->startMoving();
var_dump($day->getData());

// echo "outcome: ". $day->part1() ." \n";

// var_dump($day->getVisitedSpots());