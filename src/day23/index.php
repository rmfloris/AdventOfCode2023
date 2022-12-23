<?php
require_once '../autoload.php';
use day23\Day23;

echo "<pre>";
$seeds = new Day23(true);
$seeds->startRounds(1);
?>

<html>
    <head>
        <title>Day 10 - AOC</title>
    <link type="text/css" href="../common/style.css" rel="stylesheet" />
    </head>
    <body>
        <?php
        echo $seeds->showGrid();
        ?>
    </body>
</html>
