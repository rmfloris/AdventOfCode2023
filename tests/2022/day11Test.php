<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day11\Day11;

final class Day11Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day11();
    }

    public function testPart1(): void
    {
        $this->assertSame(117624, $this->day->part1());
    }
}