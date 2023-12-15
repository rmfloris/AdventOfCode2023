<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day11\Day11;

final class day11Test extends TestCase
{
    private mixed $day;
    private mixed $sampleDay;

    protected function setUp(): void
    {
        $this->day = new Day11();
        $this->sampleDay = new Day11(true);
    }
    
    public function testPart1Sample(): void
    {
        $this->assertSame(374, $this->sampleDay->part1());
    }

    public function testPart1(): void
    {
        $this->assertSame(9723824, $this->day->part1());
    }

    public function testPart2Sample(): void
    {
        $this->assertSame(82000210, $this->sampleDay->part2());
    }

    public function testPart2(): void
    {
        $this->assertSame(731244261352, $this->day->part2());
    }
}