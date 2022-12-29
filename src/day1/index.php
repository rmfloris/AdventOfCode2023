<?php
require_once '../autoload.php';

use day1\Day1;

$finder = new Day1();
echo "Elf with the most calories: #". $finder->getElfWithMostCalories();
echo "<br>Most calories carried are: #". $finder->getMostCaloriesWithSingleElf();
echo "<br>Top 3 have a total calories of: #". $finder->getCaloriesTop(3);