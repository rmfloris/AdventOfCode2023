<?php

namespace common;

abstract class Day {
    protected array $inputData = [];
    protected array $options = [];
    protected int $dayNumber;
    protected string $startTime;

    public function __construct($test = false)
    {
        $this->startTime = $this->getMicroSeconds();
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

    protected function getArrayFromInputFile($inputFilename = NULL): array
    {
        $inputFilename = $this->getInputFilename($inputFilename);
        return file($inputFilename, FILE_IGNORE_NEW_LINES);
        // return file($inputFilename, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    }

    protected function getInputFilename($inputFilename = NULL): string
    {
        if ($this->getOption('test')) {
            return __DIR__."/../input/sample/day{$this->dayNumber}.txt";
        } elseif(isset($inputFilename)) {
            return __DIR__."/../input/{$inputFilename}.txt";
        } else {
            return __DIR__."/../input/day{$this->dayNumber}.txt";
        }
    }

    private function getOption($value): bool
    {
        return isset($this->options[$value]);
    }

    public function getMemoryUsage(): string
    {
        $bytes = memory_get_peak_usage();
        $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor(log($bytes, 1024));

        return sprintf("%.2f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    protected function getMicroSeconds() {
        return microtime(true);
    }

    public function getElapsedTime() {
        return round($this->getMicroSeconds() - $this->startTime, 4) ." seconds\n";
    }

    abstract protected function part1();
    abstract protected function part2();
}