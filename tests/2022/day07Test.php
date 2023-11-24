<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day7\Day7;

final class Day07Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day7();
    }

    public function testPart1(): void
    {
        $this->assertSame(919137, $this->day->part1());
    }
    
    public function testPart2(): void
    {
        $this->assertSame(2877389, $this->day->part2());
    }
}