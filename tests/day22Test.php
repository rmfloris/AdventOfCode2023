<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use day22\Day22;

final class Day22Test extends TestCase
{

    private $day;
    private $dayTest;

    protected function setUp(): void
    {
        $this->day = new Day22();
        $this->dayTest = new Day22(true);
    }

    public function testPart1WithTestData(): void
    {
        $this->assertSame(6032, $this->dayTest->part1());
    }

//     public function testPart1(): void
//     {
//         $this->assertSame(0, $this->day->part1());
//     }

//     public function testPart2(): void
//     {
//         $this->assertSame(0, $this->day->part1());
//     }

    /**
     * @dataProvider provideInputData
     */
    public function testAllMovements(array $expected, array $moves, array $currentPosition, int $currentFacing): void
    {
        $this->day->setData($currentFacing, $moves, $currentPosition);
        $this->day->startMoving();
        $data = $this->day->getData();

        $this->assertSame($expected, $data["currentPosition"]);
    }

    /**
     * @dataProvider provideFacingData
     */
    public function testChangeFacing(int $expected, array $moves, array $currentPosition, int $currentFacing): void
    {
        $this->day->setData($currentFacing, $moves, $currentPosition);
        $this->day->startMoving();
        $data = $this->day->getData();

        $this->assertSame($expected, $data["currentFacing"]);
    }

    /********************************************************************
     * Dataprovides
     *******************************************************************/
    
    public function provideInputData(){
        $moves = [
            "steps"=> [
                20
            ],
            "turns" => [
                "L"
            ]
        ];
        $standardMoves = [
            "steps"=>[
                5
            ], 
            "turns"=>[
                "L"
            ]
        ];
        $movesOverflow = [
            "steps"=> [
                10
            ],
            "turns" => [
                "L"
            ]
        ];
        $currentPosition = [
            "x" => 50,
            "y" => 0
        ];

        return [
            'Moving right & hit wall' => [
                ["x"=>55, "y"=>0],
                $moves,
                $currentPosition,
                0
            ],
            'Moving left & hit wall' => [
                ["x"=>147, "y"=>0],
                $moves,
                $currentPosition,
                2
            ],
            'Moving up & hit wall' => [
                ["x"=>50, "y"=>137],
                $moves,
                $currentPosition,
                3
            ],
            'Moving down & hitwall' => [
                ["x"=>50, "y"=>6],
                $moves,
                $currentPosition,
                1
            ],
            'Moving right & hit wall on other side' => [
                ["x"=> 149, "y"=> 7],
                $moves,
                ["x"=> 146, "y"=> 7],
                0
            ],
            'Moving left & hit wall on other side' => [
                ["x"=>50, "y"=>6],
                $moves,
                ["x"=> 51, "y"=>6],
                2
            ],
            'Moving down & hit wall on other side' => [
                ["x"=>56, "y"=>149],
                $moves,
                ["x"=>56, "y"=>144],
                1
            ],
            'Moving up & hit wall on other side' => [
                ["x"=>36, "y"=>100],
                $moves,
                ["x"=>36, "y"=>104],
                3
            ],
            'Moving right' => [
                ["x"=>79, "y"=>138],
                $standardMoves,
                ["x"=>74, "y"=>138],
                0
            ],
            'Moving left' => [
                ["x"=>69, "y"=>138],
                $standardMoves,
                ["x"=>74, "y"=>138],
                2
            ],
            'Moving up' => [
                ["x"=>74, "y"=>133],
                $standardMoves,
                ["x"=>74, "y"=>138],
                3
            ],
            'Moving down' => [
                ["x"=>74, "y"=>143],
                $standardMoves,
                ["x"=>74, "y"=>138],
                1
            ],'Moving right and have overflow' => [
                ["x"=> 57, "y"=> 1],
                $movesOverflow,
                ["x"=> 147, "y"=> 1],
                0
            ],
            'Moving left and have overflow' => [
                ["x"=>50, "y"=>6],
                $movesOverflow,
                ["x"=> 51, "y"=> 6],
                2
            ],
            'Moving down and have overflow' => [
                ["x"=>56, "y"=>149],
                $movesOverflow,
                ["x"=> 56, "y"=> 144],
                1
            ],
            'Moving up and have overflow' => [
                ["x"=>36, "y"=>100],
                $movesOverflow,
                ["x"=>36, "y"=>104],
                3
            ],
            'Moving right on bottom section and have overflow' => [
                ["x"=>1, "y"=>197],
                $movesOverflow,
                ["x"=>46, "y"=>197],
                0
            ],
            'Moving left on bottom section and have overflow' => [
                ["x"=>44, "y"=>194],
                $movesOverflow,
                ["x"=>4, "y"=>194],
                2
            ],
            'Moving down on bottom section and have overflow' => [
                ["x"=>1, "y"=>100],
                $movesOverflow,
                ["x"=>1, "y"=>194],
                1
            ],
            'Moving up on bottom section and have overflow' => [
                ["x"=>6, "y"=>192],
                $movesOverflow,
                ["x"=>6, "y"=>102],
                3
            ],
            'hit a wall directly on the other side' => [
                ["x"=>49, "y"=>195],
                $movesOverflow,
                ["x"=>47, "y"=>195],
                0
            ],
            'Error Move' => [
                "expectedPosition"=>["x"=>116, "y"=>0],
                "moves"=>["steps"=>[26], "turns"=>["R"]],
                "currentPosition"=>["x"=>116, "y"=>47],
                "currentFacing"=>1
            ],
        ];
    }

    public function provideFacingData()
    {
        $movesLeftFacing = [
            "steps"=> [
                10
            ],
            "turns" => [
                "L"
            ]
        ];
        $movesRightFacing = [
            "steps"=> [
                10
            ],
            "turns" => [
                "R"
            ]
        ];

        $currentPosition = [
            "x" => 50,
            "y" => 0
        ];

        return [
            'Moving right & change left' => [
                "outcomeFacing"=>3,
                "moves"=>$movesLeftFacing,
                "currentPosition"=>$currentPosition,
                "currentFacing"=>0
            ],
            'Moving left & change left' => [
                1,
                $movesLeftFacing,
                $currentPosition,
                2
            ],
            'Moving up & change left' => [
                2,
                $movesLeftFacing,
                $currentPosition,
                3
            ],
            'Moving down & change left' => [
                0,
                $movesLeftFacing,
                $currentPosition,
                1
            ],
            'Moving right & change right' => [
                1,
                $movesRightFacing,
                $currentPosition,
                0
            ],
            'Moving left & change right' => [
                3,
                $movesRightFacing,
                $currentPosition,
                2
            ],
            'Moving up & change right' => [
                0,
                $movesRightFacing,
                $currentPosition,
                3
            ],
            'Moving down & change right' => [
                2,
                $movesRightFacing,
                $currentPosition,
                1
            ],
        ];      
    }   
}