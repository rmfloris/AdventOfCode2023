<?php

namespace common;

class Helper {
    public static function getKey(int $x, int $y) :string {
        return json_encode([(string)$x, (string)$y]);
    }
}