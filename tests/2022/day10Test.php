<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day10\Day10;

final class Day10Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day10();
    }

    public function testPart1(): void
    {
        $this->assertSame(14780, $this->day->part1());
    }
    
    public function testPart2(): void
    {
        $this->assertSame("ELPLZGZL", $this->day->part2());
    }
}