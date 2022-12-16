<?php
ini_set('max_execution_time', 180);

require_once '../autoload.php';
use day15\utils\Day15;

$filenameTest = "../input/15_input_test.txt";
$filename = "../input/15_input.txt";
// $filename = "../input/15_input_sample.txt";

echo "<pre>";

$sensors = new Day15($filename);
$sensorsTest = new Day15($filenameTest);
// $sensors->fillMap();

echo "Part 1 - Number of positions: ". $sensors->getPositionsAt(2000000) ." (5394423)<br>";
echo "Part 1 - Number of positions: ". $sensorsTest->getPositionsAt(10);
echo "<p>";
// echo $sensors->findDistress(0, 20);
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

