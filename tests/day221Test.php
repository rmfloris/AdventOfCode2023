<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day22\Day221;

final class Day221Test extends TestCase
{

    private $day;

    protected function setUp(): void
    {
        $this->day = new Day221();
    }

    public function testHitWall(): void
    {
        $lineData = "  .#.......#..  ";
        $moves = 9;

        $this->day->setData($lineData, $moves, 0);
        $this->assertSame(10, $this->day->part1());

        $this->day->setData($lineData, $moves, 1);
        $this->assertSame(10, $this->day->part1());

        $this->day->setData($lineData, $moves, 2);
        $this->assertSame(4, $this->day->part1());

        $this->day->setData($lineData, $moves, 3);
        $this->assertSame(4, $this->day->part1());
    }

    public function testHitWallOnOtherSide(): void
    {
        $lineData1 = "  #...........  ";
        $lineData2 = "  ...........#  ";
        $moves = 9;

        $this->day->setData($lineData1, $moves, 0);
        $this->assertSame(13, $this->day->part1());

        $this->day->setData($lineData1, $moves, 1);
        $this->assertSame(13, $this->day->part1());

        $this->day->setData($lineData2, $moves, 2);
        $this->assertSame(2, $this->day->part1());

        $this->day->setData($lineData2, $moves, 3);
        $this->assertSame(2, $this->day->part1());
    }

    public function testStandardMoves(): void
    {
        $lineData = "  #..........#  ";
        $moves = 2;

        $this->day->setData($lineData, $moves, 0);
        $this->assertSame(8, $this->day->part1());

        $this->day->setData($lineData, $moves, 1);
        $this->assertSame(8, $this->day->part1());

        $this->day->setData($lineData, $moves, 2);
        $this->assertSame(4, $this->day->part1());

        $this->day->setData($lineData, $moves, 3);
        $this->assertSame(4, $this->day->part1());
    }

    public function testOverflow(): void
    {
        $lineData1 = "  ...#........  ";
        $lineData2 = "  .........#..  ";
        $moves = 12;

        $this->day->setData($lineData1, $moves, 0);
        $this->assertSame(4, $this->day->part1());

        $this->day->setData($lineData1, $moves, 1);
        $this->assertSame(4, $this->day->part1());

        $this->day->setData($lineData2, $moves, 2);
        $this->assertSame(12, $this->day->part1());

        $this->day->setData($lineData2, $moves, 3);
        $this->assertSame(12, $this->day->part1());
    }

    public function testInfiniteOverflow(): void
    {
        $lineData = "  ............  ";
        $moves = 13;

        $this->day->setData($lineData, $moves, 0);
        $this->assertSame(7, $this->day->part1());

        $this->day->setData($lineData, $moves, 1);
        $this->assertSame(7, $this->day->part1());

        $this->day->setData($lineData, $moves, 2);
        $this->assertSame(4, $this->day->part1());

        $this->day->setData($lineData, $moves, 3);
        $this->assertSame(4, $this->day->part1());
    }
}