<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day8\Day8;

final class Day08Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day8();
    }

    public function testPart1(): void
    {
        $this->assertSame(1736, $this->day->part1());
    }
    
    public function testPart2(): void
    {
        $this->assertSame(268800, $this->day->part2());
    }
}