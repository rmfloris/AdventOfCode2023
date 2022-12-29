<?php
require_once '../autoload.php';
use day20\Day20;

$coords = new Day20();
echo "answer part 1: ". $coords->startMoving() ." (872)<br>";

$coords->applyDecriptionKey();
echo "answer part 2: ". $coords->startMoving(10) ." (5382459262696)<br>";


