<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day12\Day12;

final class Day12Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day12();
    }

    public function testPart1(): void
    {
        $this->assertSame(440, $this->day->part1());
    }
    
    public function testPart2(): void
    {
        $this->assertSame(439, $this->day->part2());
    }
}