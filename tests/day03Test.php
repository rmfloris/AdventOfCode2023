<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day3\Day3;

final class Day03Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day3();
    }

    public function testPart1(): void
    {
        $this->assertSame(7824, $this->day->part1());
    }
    
    public function testPart2(): void
    {
        $this->assertSame(2798, $this->day->part2());
    }
}