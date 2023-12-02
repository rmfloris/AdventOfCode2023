<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day2\Day2;

final class Day02Test extends TestCase
{

    private mixed $day;

    protected function setUp(): void
    {
        $this->day = new Day2();
    }
    
    public function testPart1(): void
    {
        $this->assertSame(2512, $this->day->part1());
    }

    public function testPart2(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
          );
        $this->assertSame(54649, $this->day->part2());
    }
}