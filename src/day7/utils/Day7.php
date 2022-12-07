<?php

namespace day7\utils;

use common\LoadInput;

class Day7 {

    private $inputArray = [];
    private $dirStructure = [];
    private $parentDirectory = [];
    private $folderSize = [];

    public function __construct($filename) {
        $this->inputArray = $this->parseInput($filename);
        $this->constructDirStructure();
        $this->calculateFolderSize($this->dirStructure);
    }

    private function parseInput($inputFile) {
        $data = explode("\n", (new LoadInput)->loadFile($inputFile));
        return $data;
    }

    private function constructDirStructure() {
        foreach($this->inputArray as $lineId => $line) {
            if($this->isCommand($line)) {
                $this->executeCommand($line, $lineId);
            }
        }
    }

    private function isCommand($line) {
        return (substr($line,0,1) == "$");
    }

    private function executeCommand($line, $lineId) {
        $commandInfo = explode(" ", $line);
        switch($commandInfo[1]){
            case 'cd':
                $this->changeDir($commandInfo[2]);
                break;
            case 'ls':
                $contentDir = $this->getDirContent($lineId);
                $this->addDirContentToStructure($contentDir);
                break;
        }
    }

    private function getDirContent($lineId) {
        $nextLines = array_slice($this->inputArray, $lineId+1);
        $nextCommand = 0;
        foreach($nextLines as $key => $line) {
            $nextCommand = count($nextLines);
            if($this->isCommand($line)) {
                $nextCommand = $key;
                break;
            }
        }
        return array_slice($this->inputArray, $lineId+1, $nextCommand);
    }

    private function addDirContentToStructure($contentDir) {
        $ref = &$this->dirStructure; //take the reference of the array.
        foreach( $this->parentDirectory as $key ) {
            $key = trim( $key );
            $ref = &$ref[$key];     //take the new reference of the item of child array based on the key from the current reference.
        }
    
        foreach($contentDir as $content) {
            $data = explode(" ", $content);
            $name = $data[1];
            $sizeOrDir = $data[0];
            $dirData[$name] = ($this->isDir($sizeOrDir) ? [] : $sizeOrDir);
            // echo "Name: ". $name ."<br>";
        }
        $ref = $dirData;
        unset($ref);
    }

    private function isDir($data) {
        return ($data == 'dir');
    }

    private function changeDir($dir) {
        switch($dir) {
            case '/':
                $this->parentDirectory = ["/"];
                $this->dirStructure["/"] = [];
                break;
            case "..":
                array_pop($this->parentDirectory);
                break;
            default:
                $this->parentDirectory = array_merge($this->parentDirectory, [$dir]);
                break;
        }
    }

    private function calculateFolderSize($startingPoint) {
        /**
         * check if it is a dir
         * sum the content
         * add to size array
         * add to parent
         * 
         */

         /**
          * $size["key"] = 123456
          */
        $parent = null;
        foreach($startingPoint as $key => $directory) {
            echo "Key: ". $key ."<br>";
            if($this->hasSubDirectory($directory)) {
                echo "subdir: ". print_r($directory, true) ."<br>";
                // $this->calculateFolderSize($directory);
            } 
            // echo "- ". print_r($directory,true) ." - ". $this->getFolderSize($directory) ."<br>";
            $this->folderSize[$key] += $this->getFolderSize($key);
        }
    }

    private function hasSubDirectory($data) {
        return is_array($data);
    }

    private function getFolderSize($directory) {
        $size = 0;
        foreach($this->dirStructure[$directory] as $content) {
            if(!$this->hasSubDirectory($content)) {
                $size += $content;
            }
        }
        return $size;
    }

    public function getDirStructure() {
        return $this->dirStructure;
    }
}