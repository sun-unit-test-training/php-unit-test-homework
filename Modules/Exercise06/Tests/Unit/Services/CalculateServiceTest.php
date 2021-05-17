<?php

namespace Tests\Unit\Services;

use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;

use InvalidArgumentException;

class CalculateServiceTest extends TestCase
{
    protected $calendarServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CalculateService();
    }

    /**
     * @dataProvider provider_test_calculate
     */
    public function test_calculate($input, $time)
    {
        $result = $this->service->calculate($input['bill'], $input['hasWatch']);

        $this->assertEquals($time, $result);
    }

    public function provider_test_calculate()
    {
        return [
            [
                [
                    'bill' => 100,
                    'hasWatch' => false,
                ], 0
            ],

            [
                [
                    'bill' => 100,
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
                    'bill' => 3000,
                    'hasWatch' => false,
                ], 60
            ],
            [
                [
                    'bill' => 3000,
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
                    'bill' => 6000,
                    'hasWatch' => false,
                ], 120
            ],
            [
                [
                    'bill' => 6000,
                    'hasWatch' => true,
                ], 300
            ],
        ];
    }

    public function test_function_throw_exception()
    {
        $bill = -10;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Bill must be greater than 0');

        $this->service->calculate($bill);
    }
}
