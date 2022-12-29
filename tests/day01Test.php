<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day1\Day1;

final class Day01Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day1();
    }
    
    public function testPart1(): void
    {
        $this->assertSame(67658, $this->day->getMostCaloriesWithSingleElf());
    }

    public function testPart2(): void
    {
        $this->assertSame(200158, $this->day->getCaloriesTop(3));
    }
}