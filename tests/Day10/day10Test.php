<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day10\Day10;

final class day10Test extends TestCase
{
    private mixed $day;
    private mixed $sampleDay;

    protected function setUp(): void
    {
        $this->day = new Day10();
        $this->sampleDay = new Day10(true);
    }
    
    public function testPart1Sample(): void
    {
        $this->assertSame(8, $this->sampleDay->part1());
    }

    public function testPart1(): void
    {
        $this->assertSame(6697, $this->day->part1());
    }

    public function testPart2Sample(): void
    {
        // $this->markTestIncomplete("To be done");
        $this->assertSame(0, $this->sampleDay->part2());
    }

    public function testPart2(): void
    {
        // $this->markTestIncomplete("To be done");
        $this->assertSame(84363105, $this->day->part2());
    }
}