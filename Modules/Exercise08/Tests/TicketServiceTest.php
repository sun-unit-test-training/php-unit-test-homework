<?php

namespace Modules\Exercise08\Tests;

use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;
use InvalidArgumentException;
use Carbon\Exceptions\InvalidFormatException;

class TicketServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new TicketService();
    }

    public function test_property()
    {
        $this->assertEquals(1800, TicketService::BASE_PRICE);
        $this->assertEquals(120, TicketService::MAX_AGE);
        $this->assertEquals(0, TicketService::MIN_AGE);
        $this->assertEquals(1400, TicketService::PRICE_FEMALE_FRIDAY);
        $this->assertEquals(1200, TicketService::PRICE_IN_TUESDAY);
        $this->assertEquals(1600, TicketService::PRICE_OVER_65);
    }

    /**
     * @dataProvider input_for_calculate_price_exception
     * @param $input
     */
    public function test_calculate_price_return_exception($input)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The age must be from 0 to 120');
        $this->service->calculatePrice($input);
    }

    public function input_for_calculate_price_exception()
    {
        return [
            [
                [
                    'booking_date' => '2021-01-27',
                    'age' => -10,
                ],
            ],
            [
                [
                    'booking_date' => '2021-01-27',
                    'age' => 121,
                ],
            ],
        ];
    }

    public function test_calculate_price_input_date_exception()
    {
        $this->expectException(InvalidFormatException::class);
        $this->service->calculatePrice([
            'name' => 'The Thao',
            'age' => 12,
            'booking_date' => 'not a date',
            'gender' => 'super human',
        ]);
    }

    /**
     * @dataProvider input_for_calculate_price
     * @param $input
     * @param $expected
     */
    public function test_calculate_price($input, $expected)
    {
        $dataPrice = $this->service->calculatePrice($input);
        $this->assertEquals($expected, $dataPrice);
    }

    public function input_for_calculate_price()
    {
        return [
            [
                [
                    'name' => 'The Thao',
                    'age' => 12,
                    'booking_date' => '2021-01-27',
                    'gender' => 'super human',
                ], 900
            ],
            [
                [
                    'name' => 'The Thao',
                    'age' => 13,
                    'booking_date' => '2021-05-04',
                    'gender' => 'super human',
                ], 1200
            ],
            [
                [
                    'name' => 'The Thao',
                    'age' => 13,
                    'booking_date' => '2021-05-07',
                    'gender' => 'female',
                ], 1400
            ],
            [
                [
                    'name' => 'The Thao',
                    'age' => 66,
                    'booking_date' => '2021-05-07',
                    'gender' => 'female',
                ], 1400
            ],
            [
                [
                    'name' => 'The Thao',
                    'age' => 66,
                    'booking_date' => '2021-05-07',
                    'gender' => 'male',
                ], 1600
            ],
            [
                [
                    'name' => 'The Thao',
                    'age' => 66,
                    'booking_date' => '2021-05-06',
                    'gender' => 'female',
                ], 1600
            ],
            [
                [
                    'name' => 'The Thao',
                    'age' => 65,
                    'booking_date' => '2021-05-06',
                    'gender' => 'male',
                ], 1800
            ],
        ];
    }
}
