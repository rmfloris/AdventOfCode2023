<?php

namespace common;

class Helper {

    /**
     * @param array<mixed> $data
     */
    public static function printRFormatted($data):void {
        echo "<pre>";
        print_r($data);
        echo "<pre>";
    }

    public static function getKey(string|int|float $x, string|int|float $y): string {
        return $x .",". $y;
    }
}