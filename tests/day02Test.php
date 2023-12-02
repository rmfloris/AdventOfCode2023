<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day2\Day2;

final class Day02Test extends TestCase
{

    private mixed $day;

    protected function setUp(): void
    {
        $this->day = new Day2();
    }
    
    public function testPart1(): void
    {
        $this->assertSame(2512, $this->day->part1());
    }

    public function testPart2(): void
    {
        $this->assertSame(67335, $this->day->part2());
    }
}