<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day6\Day6;

final class day06Test extends TestCase
{
    private mixed $day;
    private mixed $sampleDay;

    protected function setUp(): void
    {
        $this->day = new Day6();
        $this->sampleDay = new Day6(true);
    }
    
    public function testPart1Sample(): void
    {
        $this->markTestIncomplete("To be done");
        // $this->assertSame(4361, $this->sampleDay->part1());
    }

    public function testPart1(): void
    {
        $this->markTestIncomplete("To be done");
        // $this->assertSame(553079, $this->day->part1());
    }

    public function testPart2Sample(): void
    {
        $this->markTestIncomplete("To be done");
        // $this->assertSame(467835, $this->sampleDay->part2());
    }

    public function testPart2(): void
    {
        $this->markTestIncomplete("To be done");
        // $this->assertSame(84363105, $this->day->part2());
    }
}