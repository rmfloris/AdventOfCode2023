<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day21\Day21;

final class Day21Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day21();
    }
    
    public function testPart1(): void
    {
        $this->assertSame(80326079210554, $this->day->part1());
    }
}