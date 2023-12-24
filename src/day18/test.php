<?php
require_once '../autoload.php';

use common\Picks;
use common\Shoelace;

$pointsTest1 = [
    [1,6],
    [3,1],
    [7,2],
    [4,4],
    [8,5]
];

$points = [
    [0,3],
    [2,4],
    [4,5],
    [4,4],
    [4,3],
    [3,2],
    [2,1],
    [1,0]
];

$area = new Shoelace;
$inter = new Picks;

for($i=0;$i<count($points); $i++) {
    $z = $i+1;
    if($z >= count($points)) $z = 0;

    $area->addPoints($points[$i][0], $points[$i][1], $points[$z][0], $points[$z][1]);
}

echo "area: ". $area->getAreaSize() ."<br>";

$inter->setArea($area->getAreaSize());
$inter->setBoundries(count($points));
echo "points: ". $inter->calculateInteriorPoints() ."<br>";