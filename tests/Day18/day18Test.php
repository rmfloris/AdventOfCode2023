<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day18\Day18;

final class day18Test extends TestCase
{
    private mixed $day;
    private mixed $sampleDay;

    protected function setUp(): void
    {
        $this->day = new Day18();
        $this->sampleDay = new Day18(true);
    }
    
    public function testPart1Sample(): void
    {
        $this->assertSame(62, $this->sampleDay->part1());
    }

    public function testPart1(): void
    {
        $this->assertSame(56678, $this->day->part1());
    }

    public function testPart2Sample(): void
    {
        $this->assertSame(952408144115, $this->sampleDay->part2());
    }

    public function testPart2(): void
    {
        $this->assertSame(79088855654037, $this->day->part2());
    }
}