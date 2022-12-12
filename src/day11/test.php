<?php

$data[0] = [71,89];
$data[1] = [];
$data[2] = [200,250];


while($val = current($data)) {
    echo "Key: ". key($data) ."<br>";
    $key = key($data);
    while($item = current($data[$key])){
        echo "item: ". $item ."<br>";
        next($data[$key]);
    }
    next($data);
}