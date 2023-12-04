<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day4\Day4;

final class day04Test extends TestCase
{
    private mixed $day;
    private mixed $sampleDay;

    protected function setUp(): void
    {
        $this->day = new Day4();
        $this->sampleDay = new Day4(true);
    }
    
    public function testPart1Sample(): void
    {
        // $this->markTestIncomplete("To be done");
        $this->assertSame(13, $this->sampleDay->part1());
    }

    public function testPart1(): void
    {
        // $this->markTestIncomplete("To be done");
        $this->assertSame(20855, $this->day->part1());
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