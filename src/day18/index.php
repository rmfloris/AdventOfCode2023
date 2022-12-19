<?php
require_once '../autoload.php';
use day18\utils\Day18;

// $filename = "../input/18_input_test.txt";
$filename = "../input/18_input.txt";
echo "<pre>";

$dice = new Day18($filename);

echo "Number of visible sides: ". $dice->getSides() ."<br>";

// var_dump($dice);