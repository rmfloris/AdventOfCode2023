<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day22\Day22;

final class Day22Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day22();
    }

    public function testPart1(): void
    {
        $this->assertSame(0, $this->day->part1());
    }

    public function testPart2(): void
    {
        $this->assertSame(0, $this->day->part1());
    }
}