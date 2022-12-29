<?php
require_once '../autoload.php';
use day18\Day18;

echo "<pre>";
$dice = new Day18();

echo "Number of visible sides: ". $dice->getSides() ." (3522)<br>";

$dice->preparePart2();
echo "Number of visible sides: ". $dice->getSurfaceCount() ." (2074)<br>";
