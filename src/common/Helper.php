<?php

namespace common;

/**
 * @var array<mixed>
 */
class Helper {

    public static function printRFormatted($data) {
        echo "<pre>";
        print_r($data);
        echo "<pre>";
    }
}