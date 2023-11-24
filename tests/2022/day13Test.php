<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day13\Day13;

final class Day13Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day13();
    }

    public function testPart1(): void
    {
        $this->assertSame(5506, $this->day->part1());
    }
}