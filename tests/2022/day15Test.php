<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day15\Day15;

final class Day15Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day15();
    }

    public function testPart1(): void
    {
        $this->assertSame(5394423, $this->day->part1());
    }
    
    public function testPart2(): void
    {
        $this->assertSame(11840879211051, $this->day->part2());
    }
}