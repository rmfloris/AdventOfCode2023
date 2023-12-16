<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day12\Day12;

final class day12Test extends TestCase
{
    private mixed $day;
    private mixed $sampleDay;

    protected function setUp(): void
    {
        $this->day = new Day12();
        $this->sampleDay = new Day12(true);
    }
    
    public function testPart1Sample(): void
    {
        // $this->markTestIncomplete("To be done");
        $this->assertSame(21, $this->sampleDay->part1());
    }

    public function testPart1(): void
    {
        // $this->markTestIncomplete("To be done");
        $this->assertSame(7260, $this->day->part1());
    }

    public function testPart2Sample(): void
    {
        // $this->markTestIncomplete("To be done");
        // $this->assertSame(525152, $this->sampleDay->part2());
    }

    public function testPart2(): void
    {
        $this->markTestIncomplete("To be done");
        // $this->assertSame(84363105, $this->day->part2());
    }
}