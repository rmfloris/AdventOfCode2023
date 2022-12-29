<?php

namespace common;

class Day {
    protected array $inputData = [];
    protected array $options = [];
    protected int $dayNumber;

    public function __construct($test = false)
    {
        $className = get_class($this);
        preg_match("#\d+#", $className, $matches);
        $this->dayNumber = $matches[0];
        
        if($test) $this->setOption("test");
        
        $this->loadData();

        return $this;
        
    }

    public function setOption($value): void
    {
        $this->options[$value] = true;
    }

    protected function loadData(): void
    {
        $this->inputData = $this->getArrayFromInputFile();
    }

    protected function getArrayFromInputFile(): array
    {
        $inputFilename = $this->getInputFilename();
        return file($inputFilename, FILE_IGNORE_NEW_LINES);
        // return file($inputFilename, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    }

    protected function getInputFilename(): string
    {
        if ($this->getOption('test')) {
            return __DIR__."/../input/sample/day{$this->dayNumber}.txt";
        } else {
            return __DIR__."/../input/day{$this->dayNumber}.txt";
        }
    }

    private function getOption($value): bool
    {
        return isset($this->options[$value]);
    }
}