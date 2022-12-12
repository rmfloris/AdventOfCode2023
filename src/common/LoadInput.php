<?php

namespace common;

class LoadInput {

    public function loadFile($filename) {
        $file = fopen($filename, "r") or die("Unable to open file!");
        $data = fread($file,filesize($filename));
        fclose($file);

        return $data;
    }

    public function loadFileToLines($filename) {
        return explode("\n", $this->readFile($filename));
    }

    private function readFile($filename) {
        $file = fopen($filename, "r") or die("Unable to open file!");
        $data = fread($file,filesize($filename));
        fclose($file);

        return $data;
    }
}