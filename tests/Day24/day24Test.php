<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day24\Day24;

final class day24Test extends TestCase
{
    private mixed $day;
    private mixed $sampleDay;

    protected function setUp(): void
    {
        $this->day = new Day24();
        $this->sampleDay = new Day24(true);
    }
    
    public function testPart1Sample(): void
    {
        $this->sampleDay->setBoundries(7,27);
        $this->assertSame(2, $this->sampleDay->part1());
    }

    public function testPart1(): void
    {
        $this->day->setBoundries(200000000000000,400000000000000);
        $this->assertSame(19523, $this->day->part1());
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