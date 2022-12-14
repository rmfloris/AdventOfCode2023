<?php
require_once '../autoload.php';
use day14\utils\Day14;

$filename = "input/input_test.txt";
$filename = "input/input.txt";

echo "<pre>";

$sand = new Day14($filename);
// echo "score: ". $sand->dropSandUnits(25);
echo "score part 1: ". $sand->dropSandUnits1() ." (1199) <br>";
// var_dump($sand);
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

