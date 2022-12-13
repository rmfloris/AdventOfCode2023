<?php
require_once '../autoload.php';
error_reporting(E_ALL & ~E_WARNING);
use day13\utils\Day13;

$filename = "input/input_test.txt";
$filename = "input/input_sample.txt";
$filename = "input/input.txt";

echo "<pre>";

$distress = new Day13($filename);
$distress->startComparing();
echo "<p>";
echo "are these the same?<p>";
echo "Part 1, sum of pairs: ". $distress->getSumOfIndices() ." (5506)";

$distress->addPackage(json_decode('[[2]]'));
$distress->addPackage(json_decode('[[6]]'));

var_dump($distress);