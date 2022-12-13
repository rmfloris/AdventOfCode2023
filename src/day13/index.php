<?php
require_once '../autoload.php';
error_reporting(E_ALL & ~E_WARNING);
use day13\utils\Day13;

// $filename = "input/input_test.txt";
$filename = "input/input.txt";
echo "<pre>";

$distress = new Day13($filename);
$distress->startComparing();
echo "<p>";
echo "are these the same?<p>";
echo "Part 1, sum of pairs: ". $distress->getSumOfIndices() ." (first guess 5841, too high)";
/**
 * value of 5841 is too high
 * number of pairs is correct
 * all pairs have either a 0 or 1 value
 */

echo "<p>Pairs:" . print_r($distress->getPairs(), true) ."<br>";
// echo "<pre>";
// var_dump($path);