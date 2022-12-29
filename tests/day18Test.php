<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day18\Day18;

final class Day18Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day18();
    }
    
    public function testPart1(): void
    {
        $this->assertSame(3522, $this->day->getSides());
    }

    public function testPart2(): void
    {
        $this->assertSame(2074, $this->day->preparePart2()->getSurfaceCount());
    }
}