<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day9\Day9;

final class Day09Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day9();
    }

    public function testPart1(): void
    {
        $this->assertSame(6057, $this->day->part1());
    }
    
    public function testPart2(): void
    {
        $this->assertSame(2514, $this->day->part2());
    }
}