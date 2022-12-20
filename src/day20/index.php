<?php
require_once '../autoload.php';
use day20\utils\Day20;

$filename = "../input/20_input_test.txt";
$filename = "../input/20_input.txt";
echo "<pre>";

$coords = new Day20($filename);
echo "answer part 1: ". $coords->startMoving() ." (872)<br>";

$coords->applyDecriptionKey();
echo "answer part 2: ". $coords->startMoving(10) ." (5382459262696)<br>";


// echo "--". $coords->getValues();