<?php
require_once '../autoload.php';

/**
 * not resolved. Used solution from the internet.
 * something for the christmas holidays
 */

use day7\Day7;

$filename = "input/input_test.txt";
// $filename = "input/input.txt";

$size = new Day7(true);

echo "<P>Directory Structure<pre>";
print_r($size->getDirStructure());

// var_dump($size);