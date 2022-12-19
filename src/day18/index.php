<?php
require_once '../autoload.php';
use day18\utils\Day18;

$filename = "../input/18_input_test.txt";
$filename = "../input/18_input.txt";
echo "<pre>";

$dice = new Day18($filename);

echo "Number of visible sides: ". $dice->getSides() ." (3522)<br>";

$dice->preparePart2();
echo "Number of visible sides: ". $dice->getSurfaceCount() ." (2074)<br>";

// var_dump($dice);