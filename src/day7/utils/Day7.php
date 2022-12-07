<?php

namespace day7\utils;

use common\LoadInput;

class Day7 {

    private $inputArray = [];
    private $dirStructure = [];
    private $parentDirectory = [];
    // private $dirRef = [];

    public function __construct($filename) {
        $this->inputArray = $this->parseInput($filename);
        // $this->dirRef = & $this->dirStructure;
        $this->constructDirStructure();
    }

    private function parseInput($inputFile) {
        $data = explode("\n", (new LoadInput)->loadFile($inputFile));
        return $data;
    }

    private function constructDirStructure() {
        /*
        - / (dir)
            - a (dir)
                - e (dir)
                - i (file, size=584)
                - f (file, size=29116)
                - g (file, size=2557)
                - h.lst (file, size=62596)
            - b.txt (file, size=14848514)
            - c.dat (file, size=8504156)
            - d (dir)
                - j (file, size=4060174)
                - d.log (file, size=8033020)
                - d.ext (file, size=5626152)
                - k (file, size=7214296)
    */
        
        foreach($this->inputArray as $lineId => $line) {
            echo "* Line: ". $line ."<br>";
            echo "  - is command? ". $this->isCommand($line) ."<br>";
            if($this->isCommand($line)) {
                $this->executeCommand($line, $lineId);
            }
            echo "  - Parent Dir: ". print_r($this->parentDirectory, true) ."<br>";
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
                // echo "<pre>". print_r($contentDir, true) ."</pre><br>";
                $this->addDirContentToStructure($contentDir);
                break;
        }
    }

    private function getDirContent($lineId) {
        $nextLines = array_slice($this->inputArray, $lineId+1);
        $nextCommand = 0;
        foreach($nextLines as $key => $line) {
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
            $dirData[$name] = $name;
            echo "Name: ". $name ."<br>";
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
                // $this->dirRef = &$this->dirRef["/"];
                $this->dirStructure["/"] = [];
                // $this->currentDirLevel = 1;
                break;
            case "..":
                array_pop($this->parentDirectory);
                // array_pop($this->dirRef);
                // $this->currentDirLevel--;
                break;
            default:
                $this->parentDirectory = array_merge($this->parentDirectory, [$dir]);
                // $this->dirRef = &$this->dirRef[$dir];
                // $this->currentDirLevel++;
                break;
        }
    }

    public function getDirStructure() {
        return $this->dirStructure;
    }
}