<?php

namespace Modules\Exercise06\Tests\Unit\Services;

use Tests\TestCase;
use InvalidArgumentException;
use Modules\Exercise06\Services\CalculateService;

class CalculateServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CalculateService();
    }

    public function test_calculate_return_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Bill must be greater than 0');

        $this->service->calculate(-1);
    }

    /**
     * @param $input
     * @param $expected
     * @dataProvider billGreateThanMinBill1
     * @dataProvider billGreateThanMinBill2
     * @dataProvider billLessThanMinBill
     * @dataProvider hasWatch
     */
    public function test_calculate_function($input, $expected)
    {
        $result = $this->service->calculate($input['bill'], $input['hasWatch']);

        $this->assertEquals($expected, $result);
    }

    public function billGreateThanMinBill1()
    {
        return [
            [
                [
                    'bill' => 2001,
                    'hasWatch' => false,
                ],
                60
            ],
        ];
    }

    public function billGreateThanMinBill2()
    {
        return [
            [
                [
                    'bill' => 5001,
                    'hasWatch' => false,
                ],
                120
            ],
        ];
    }

    public function billLessThanMinBill()
    {
        return [
            [
                [
                    'bill' => 1,
                    'hasWatch' => false,
                ],
                0
            ],
        ];
    }

    public function hasWatch()
    {
        return [
            [
                [
                    'bill' => 1,
                    'hasWatch' => true,
                ],
                180
            ],
        ];
    }
}
