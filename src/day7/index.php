<?php
require_once '../autoload.php';

use day7\utils\Day7;

$filename = "input/input_test.txt";
// $filename = "input/input.txt";

$size = new Day7($filename);

echo "<P>Directory Structure<pre>";
print_r($size->getDirStructure());

// var_dump($size);