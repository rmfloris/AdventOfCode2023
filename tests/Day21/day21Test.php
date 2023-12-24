<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day21\Day21;

final class day21Test extends TestCase
{
    private mixed $day;
    private mixed $sampleDay;

    protected function setUp(): void
    {
        $this->day = new Day21();
        $this->sampleDay = new Day21(true);
    }
    
    public function testPart1Sample(): void
    {
        $this->sampleDay->setSteps(6);
        $this->assertSame(16, $this->sampleDay->part1());
    }

    public function testPart1(): void
    {
        $this->day->setSteps(64);
        $this->assertSame(3830, $this->day->part1());
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