<?php
require_once '../autoload.php';
use day25\Day25;

echo "<pre>";
$snafu = new Day25();
echo "Part 1, Snafu number: ". $snafu->getNumber() ." (2-212-2---=00-1--102)<br>";