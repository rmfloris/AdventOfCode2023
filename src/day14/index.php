<?php
require_once '../autoload.php';
use day14\utils\Day14;

$filename = "input/input_test.txt";
$filename = "input/input.txt";

echo "<pre>";

$sand = new Day14($filename);
// echo "score: ". $sand->dropSandUnits(95, 2);
echo "score part 1: ". $sand->dropSandUnits1() ." (1199) <br>";

$sand->setPart(2);
echo "score part 2: ". $sand->dropSandUnits1() ." (23925) <br>";
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

