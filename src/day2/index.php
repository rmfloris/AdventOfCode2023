<?php

require_once '../autoload.php';

use day2\utils\ScoreCalculator;

$file = "input/input.txt";
// $file = "input/input_test.txt";

$score = new scoreCalculator($file);
echo $score->calculateResult();

