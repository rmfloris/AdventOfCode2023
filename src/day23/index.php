<?php
require_once '../autoload.php';
use day23\Day23;

echo "<pre>";
$seeds = new Day23();
$seeds->startRounds(10);
echo "empty fields: ". $seeds->countEmptyGround() ." (4195)<br>";
 
$rounds = new Day23();
$rounds->startRounds(2000);
echo "Number of Rounds: ". $rounds->getRounds() ." (1069) <br>";
?>

<html>
    <head>
        <title>Day 23 - AOC</title>
    <link type="text/css" href="../common/style.css" rel="stylesheet" />
    </head>
    <body>
        <?php
        // echo $rounds->showGrid();
        ?>
    </body>
</html>
