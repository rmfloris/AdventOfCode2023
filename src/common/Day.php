<?php

namespace common;

abstract class Day {
    /** @var array<mixed> */
    protected array $inputData;
    /** @var array<mixed> */
    protected array $options;
    protected int $dayNumber;
    protected float $startTime;
    protected bool $debug = false;

    public function __construct(bool $test = false)
    {
        $this->startTime = $this->getMicroSeconds();
        $className = get_class($this);
        preg_match("#\d+#", $className, $matches);
        $this->dayNumber = (int) $matches[0];
        
        if($test) $this->setOption("test");
        
        $this->loadData();
    }

    public function setOption(string $value): void
    {
        $this->options[$value] = true;
    }

    protected function loadData(): void
    {
        $this->inputData = $this->getArrayFromInputFile();
    }

    /**
     * @return array<mixed>
     */
    protected function getArrayFromInputFile(?string $inputFilename = NULL): array
    {
        $inputFilename = $this->getInputFilename($inputFilename);
        return file($inputFilename, FILE_IGNORE_NEW_LINES);
        // return file($inputFilename, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    }

    protected function getInputFilename(string $inputFilename = NULL): string
    {
        if ($this->getOption('test')) {
            return __DIR__."/../input/sample/day{$this->dayNumber}.txt";
        } elseif(isset($inputFilename)) {
            return __DIR__."/../input/{$inputFilename}.txt";
        } else {
            return __DIR__."/../input/day{$this->dayNumber}.txt";
        }
    }

    private function getOption(string $value): bool
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

    protected function getMicroSeconds(): float
    {
        return microtime(true);
    }

    public function getElapsedTime(): string
    {
        return round($this->getMicroSeconds() - $this->startTime, 4) ." seconds\n";
    }

    public function setDebugMode(): void
    {
        $this->debug = true;
    }

    protected function printOut(string $title, mixed $value): void
    {
        if($this->debug) { 
            echo $title. ": ". (is_array($value) ? print_r($value, true) : $value) ."\n";
        }
    }

    protected function getInputFile(): string
    {
        $inputFilename = $this->getInputFilename();
        return file_get_contents($inputFilename);
    }

    abstract protected function part1(): int|string;
    abstract protected function part2(): int|string;
}