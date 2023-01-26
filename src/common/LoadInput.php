<?php

namespace common;

class LoadInput {

    public function loadFile(string $filename): string {
        $file = fopen($filename, "r") or die("Unable to open file!");
        $data = fread($file,filesize($filename));
        fclose($file);

        return $data;
    }

    /**
     * @return array<mixed>
     */
    public function loadFileToLines(string $filename): array {
        return explode("\n", $this->readFile($filename));
    }


    private function readFile(string $filename): string {
        $file = fopen($filename, "r") or die("Unable to open file!");
        $data = fread($file,filesize($filename));
        fclose($file);

        return $data;
    }
}