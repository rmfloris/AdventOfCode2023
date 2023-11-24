<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day5\Day5;

final class Day05Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day5();
    }

    public function testPart1(): void
    {
        $this->assertSame("SHQWSRBDL", $this->day->part1());
    }
    
    public function testPart2(): void
    {
        $this->assertSame("CDTQZHBRS", $this->day->part2());
    }
}