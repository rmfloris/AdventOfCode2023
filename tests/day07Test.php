<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day7\Day7;

final class day07Test extends TestCase
{
    private mixed $day;
    private mixed $sampleDay;

    protected function setUp(): void
    {
        $this->day = new Day7();
        $this->sampleDay = new Day7(true);
    }
    
    public function testPart1Sample(): void
    {
        $this->assertSame(6440, $this->sampleDay->part1());
    }

    public function testPart1(): void
    {
        $this->assertSame(253954294, $this->day->part1());
    }

    public function testPart2Sample(): void
    {
        $this->assertSame(5905, $this->sampleDay->part2());
    }

    public function testPart2(): void
    {
        // $this->markTestIncomplete("To be done");
        $this->assertSame(254837398, $this->day->part2());
    }
}