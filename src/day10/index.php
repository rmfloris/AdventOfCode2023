<?php
require_once '../autoload.php';
$filename = "input/input_test.txt";
$filename = "input/input_test_large.txt";
$filename = "input/input.txt";

use day10\utils\Day10;

$computer = new Day10($filename);
$computer->startProgram();

echo "1.Total signal strenght: " . $computer->getSignalStrength() ." (14780)<br>";
?>
<html>
    <head>
        <title>Day 10 - AOC</title>
    <link type="text/css" href="../common/style.css" rel="stylesheet" />
    </head>
    <body>
        2. Answer: (ELPLZGZL)
        <?php
        echo $computer->showGrid();
        ?>
    </body>
</html>

