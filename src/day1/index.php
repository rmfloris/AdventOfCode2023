<?php
require_once '../autoload.php';

use day1\utils\CaloriesFinder;
// include("CaloriesFinder.php");

$file = "input/input.txt";

$finder = new CaloriesFinder($file);
echo "Elf with the most calories: #". $finder->getElfWithMostCalories();
echo "<br>Most calories carried are: #". $finder->getMostCaloriesWithSingleElf();
echo "<br>Top 3 have a total calories of: #". $finder->getCaloriesTop(3);