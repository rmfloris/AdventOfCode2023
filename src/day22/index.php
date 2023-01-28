<?php
require_once '../autoload.php';

use day22\Day22;

echo "<pre>";

$day = new Day22();
echo "outcome: ". $day->part1() ." \n";
$moves = [
    "steps"=> [
        10
    ],
    "turns" => [
        "L"
    ]
];  

$currentPosition = [
    "x" => 46,
    "y" => 197
];

$day->setData(0, $moves, $currentPosition);
$day->startMoving();
var_dump($day->getData());
print_r(["x"=>1, "y"=>197]);
// echo "outcome: ". $day->part1() ." \n";

// var_dump($day->getVisitedSpots());