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
}