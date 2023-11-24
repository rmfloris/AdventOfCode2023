<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day14\Day14;

final class Day14Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day14();
    }

    public function testPart1(): void
    {
        $this->assertSame(1199, $this->day->part1());
    }
    
    public function testPart2(): void
    {
        $this->assertSame(23925, $this->day->part2());
    }
}