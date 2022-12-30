<?php
require_once '../autoload.php';
use day14\Day14;

echo "<pre>";

$sand = new Day14();
echo "score part 1: ". $sand->part1() ." (1199) <br>";

echo "score part 2: ". $sand->part2() ." (23925) <br>";
?>
<html>
    <head>
        <title>Day 14 - AOC</title>
    <link type="text/css" href="../common/style.css" rel="stylesheet" />
    </head>
    <body>
        <?php
        echo $sand->printGraph();
        ?>
    </body>
</html>

