<?php

namespace Modules\Exercise06\Tests;

use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;
use InvalidArgumentException;

class CalculateServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CalculateService();
    }

    public function test_property()
    {
        $this->assertEquals([2000, 60], CalculateService::CASE_1);
        $this->assertEquals([5000, 120], CalculateService::CASE_2);
        $this->assertEquals(180, CalculateService::FREE_TIME_FOR_MOVIE);
    }

    public function test_calculate_return_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Bill must be greater than 0');
        $this->service->calculate(-1102, false);
    }

    /**
     * @dataProvider input_for_calculate
     * @param $input
     * @param $expected
     */
    public function test_calculate($input, $expected)
    {
        $time = $this->service->calculate($input['bill'], $input['hasWatch']);
        $this->assertEquals($expected, $time);
    }

    public function input_for_calculate()
    {
        return [
            [
                [
                    'bill' => 111,
                    'hasWatch' => false,
                ], 0
            ],
            [
                [
                    'bill' => 111,
                    'hasWatch' => true,
                ], 180
            ],
            [
                [
                    'bill' => 2000,
                    'hasWatch' => false,
                ], 60
            ],
            [
                [
                    'bill' => 2000,
                    'hasWatch' => true,
                ], 240
            ],
            [
                [
                    'bill' => 5000,
                    'hasWatch' => false,
                ], 120
            ],
            [
                [
                    'bill' => 5000,
                    'hasWatch' => true,
                ], 300
            ],
            [
                [
                    'bill' => 5001,
                    'hasWatch' => true,
                ], 300
            ],
        ];
    }
}
