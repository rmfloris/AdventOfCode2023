<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day6\Day6;

final class Day06Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day6();
    }

    public function testPart1(): void
    {
        $this->assertSame(1702, $this->day->part1());
    }
    
    public function testPart2(): void
    {
        $this->assertSame(3559, $this->day->part2());
    }
}