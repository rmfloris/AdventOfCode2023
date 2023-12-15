<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day15\Day15;

final class day15Test extends TestCase
{
    private mixed $day;
    private mixed $sampleDay;

    protected function setUp(): void
    {
        $this->day = new Day15();
        $this->sampleDay = new Day15(true);
    }
    
    public function testPart1Sample(): void
    {
        $this->assertSame(1320, $this->sampleDay->part1());
    }

    public function testPart1(): void
    {
        $this->assertSame(519603, $this->day->part1());
    }

    public function testPart2Sample(): void
    {
        $this->assertSame(145, $this->sampleDay->part2());
    }

    public function testPart2(): void
    {
        // $this->markTestIncomplete("To be done");
        $this->assertSame(244342, $this->day->part2());
    }
}