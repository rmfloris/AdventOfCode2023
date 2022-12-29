<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day20\Day20;

final class Day20Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day20();
    }
    
    public function testPart1(): void
    {
        $this->assertSame(872, $this->day->startMoving());
    }

    public function testPart2(): void
    {
        $this->assertSame(5382459262696, $this->day->applyDecriptionKey()->startMoving(10));
    }
}