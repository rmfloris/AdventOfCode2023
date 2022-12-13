<?php
require_once '../autoload.php';
error_reporting(E_ALL & ~E_WARNING);
use day13\utils\Day13;

$filename = "input/input_test.txt";
// $filename = "input/input.txt";
echo "<pre>";

$path = new Day13($filename);
echo "<p>";
echo "are these the same?";
print_r($path->startComparing());
    
// echo "<pre>";
// var_dump($path);