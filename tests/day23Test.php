<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day23\Day23;

final class Day23Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day23();
    }
    
    public function testPart1(): void
    {
        $this->assertSame(4195, $this->day->startRounds(10)->part1());
    }

    public function testPart2(): void
    {
        $this->assertSame(1069, $this->day->startRounds(2000)->part2());
    }
}