<?php
ini_set('max_execution_time', 180);

require_once '../autoload.php';
use day15\Day15;

echo "<pre>";

$sensors = new Day15();

echo "Part 1 - Number of positions: ". $sensors->part1() ." (5394423)<br>";
echo "<p>";
echo "Part 1 (test data) Distress frequency: ". $sensors->part2() ." (11840879211051)<br>";
?>
<html>
    <head>
        <title>Day 15 - AOC</title>
    <link type="text/css" href="../common/style.css" rel="stylesheet" />
    </head>
    <body>
        <?php
        // echo $sensorsTest->printGraph();
        ?>
    </body>
</html>

