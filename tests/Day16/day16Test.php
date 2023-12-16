<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day16\Day16;

final class day16Test extends TestCase
{
    private mixed $day;
    private mixed $sampleDay;

    protected function setUp(): void
    {
        $this->day = new Day16();
        $this->sampleDay = new Day16(true);
    }
    
    public function testPart1Sample(): void
    {
        $this->assertSame(46, $this->sampleDay->part1());
    }

    public function testPart1(): void
    {
        $this->assertSame(7074, $this->day->part1());
    }

    public function testPart2Sample(): void
    {
        $this->assertSame(51, $this->sampleDay->part2());
    }

    public function testPart2(): void
    {
        $this->assertSame(7530, $this->day->part2());
    }
}