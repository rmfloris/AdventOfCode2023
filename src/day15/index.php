<?php
ini_set('max_execution_time', 180);

require_once '../autoload.php';
use day15\utils\Day15;

$filename = "input/input_test.txt";
$filename = "input/input.txt";
// $filename = "input/input_sample.txt";

echo "<pre>";

$sensors = new Day15($filename);

echo "Part 1 - Number of positions: ". $sensors->getPositionsAt(2000000);

?>
<html>
    <head>
        <title>Day 15 - AOC</title>
    <link type="text/css" href="../common/style.css" rel="stylesheet" />
    </head>
    <body>
        <?php
        // echo $sensors->printGraph();
        ?>
    </body>
</html>

