<?php
require_once '../autoload.php';

use day10\Day10;

$computer = new Day10();

echo "1.Total signal strenght: " . $computer->part1() ." (14780)<br>";
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

