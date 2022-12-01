<?php

include("CaloriesFinder.php");

$file = "input/input.txt";

$finder = new CaloriesFinder($file);
echo "Elf with the most calories: #". $finder->getElfWithMostCalories();
echo "<br>Most calories carried are: #". $finder->getMostCaloriesWithSingleElf();
