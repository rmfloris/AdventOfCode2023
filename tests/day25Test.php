<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day25\day25;

final class Day25Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day25();
    }
    
    public function testPart1(): void
    {
        $this->assertSame("2-212-2---=00-1--102", $this->day->getNumber());
    }

    public function testPart2(): void
    {
        $this->markTestIncomplete(
            'Solution has not been written.'
          );
    }
}