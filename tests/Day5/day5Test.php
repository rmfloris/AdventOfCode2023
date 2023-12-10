<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day5\Day5;

final class day05Test extends TestCase
{
    private mixed $day;
    private mixed $sampleDay;

    protected function setUp(): void
    {
        $this->day = new Day5();
        $this->sampleDay = new Day5(true);
    }
    
    public function testPart1Sample(): void
    {
        // $this->markTestIncomplete("To be done");
        $this->assertSame(35, $this->sampleDay->part1());
    }

    public function testPart1(): void
    {
        // $this->markTestIncomplete("To be done");
        $this->assertSame(600279879, $this->day->part1());
    }

    public function testPart2Sample(): void
    {
        // $this->markTestIncomplete("To be done");
        $this->assertSame(46, $this->sampleDay->part2());
    }

    public function testPart2(): void
    {
        // $this->markTestIncomplete("To be done");
        $this->assertSame(20191102, $this->day->part2());
    }
}