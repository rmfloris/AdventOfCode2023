<?php
echo "<pre>";

function calculateSupport(array $map): int
{
    $r = 0;
    foreach ($map as $row) {
        foreach ($row as $key => $char) {
            if ($char === 'O') {
                $r += count($row) - $key;
            }
        }
    }
    return $r;
}


function cycle(array $map, array &$cache): array
{
    for ($i = 0; $i < 4; $i ++) {
        // echo "start: ". json_encode($map) ."<br>";
        $map = rotateMapClockwise($map);
        // echo "rotate: ". json_encode($map) ."<br>";
        $map = transformMap($map, $cache);
        // echo "transform: ". json_encode($map) ."<br>";
    }
    return $map;
}

function rotateMapClockwise(array $map): array
{
    return array_map(null, ...array_reverse($map));
}

function transformMap(array $map, array &$cache): array
{
    foreach ($map as $key => $row) {
        $cKey = json_encode($row);
        if (isset($cache[$cKey])) {
            // echo "row is in cache on key ". $key ."<br>";
            $map[$key] = $cache[$cKey];
            continue;
        }
        $map[$key] = transformRow($row);
        $cache[$cKey] = $map[$key];
    }
    return $map;
}

function transformRow(array $row): array
{
    for ($i = count($row) - 1; $i > 0; $i--) {
        $current = $row[$i];
        $previous = $row[$i-1];
        if ($current === '.' && $previous === 'O') {
            $row[$i] = $previous;
            $row[$i-1] = $current;
            $row = transformRow($row);
        }
    }
    return $row;
}

$map = file_get_contents('inputSample.txt');
$map = explode(PHP_EOL, $map);
foreach ($map as $key => $row) {
    $map[$key] = str_split($row);
}
// echo "<pre>";
// print_r($map);

$cache = [];
$loopEveryStep = 0;
$cycle = 1000000000;
// $cycle = 200;
for ($i = 0; $i < $cycle; $i++) {
    $cKey = json_encode($map);
    if (isset($cache[$cKey])) {
        echo "Map is in cache on cycle ". $i ."<br>";
        echo "i: ". $i ."<br>";
        echo "cache: ". $cache[$cKey] ."<br>";
        $loopEveryStep = $i - $cache[$cKey];
        break;
    }
    $cache[$cKey] = $i;
    $map = cycle($map, $cache);
}
$newSteps = ($cycle-$i)%$loopEveryStep;
echo $cycle. " - ". $i ." - ". $loopEveryStep ."<br>";
echo "newSteps: ". $newSteps ."<br>";
for ($j=0; $j<$newSteps; $j++) {
    $map = cycle($map, $cache);
}

echo calculateSupport(array_map(null, ...$map)) . PHP_EOL;
echo "done";