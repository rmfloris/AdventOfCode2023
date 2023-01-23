<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day25\Day25;

final class Day25Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day25();
    }
    
    public function testPart1(): void
    {
        $this->assertSame("2-212-2---=00-1--102", $this->day->part1());
    }
}