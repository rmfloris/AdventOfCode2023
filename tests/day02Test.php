<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day2\Day2;

final class Day02Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day2();
    }
    
    public function testPart2(): void
    {
        $this->assertSame(10835, $this->day->calculateResult());
    }
}