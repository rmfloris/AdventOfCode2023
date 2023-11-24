<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day4\Day4;

final class Day04Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day4();
    }

    public function testPart1(): void
    {
        $this->assertSame(576, $this->day->part1());
    }
    
    public function testPart2(): void
    {
        $this->assertSame(905, $this->day->part2());
    }
}