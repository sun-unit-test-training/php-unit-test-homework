<?php

namespace Modules\Exercise08\Tests\Unit\Services;

use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;
use InvalidArgumentException;

class TicketServiceTest extends TestCase
{
    public function test_calculate_price_with_age_invalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('The age must be from 0 to 120');

        $service = new TicketService();
        $service->calculatePrice([
            'age' => -1,
            'booking_date' => '2020-10-10 00:00:00',
        ]);
    }
    /**
     * @param $input
     * @param $expected
     * @dataProvider calculate_price_data
     */
    public function test_caluculate_price_function($input, $expected)
    {
        $service = new TicketService();

        $result = $service->calculatePrice($input);

        $this->assertEquals($expected, $result);
    }

    public function calculate_price_data()
    {
        return [
            [
                [
                    'age' => 12,
                    'booking_date' => '2020-10-10 00:00:00',
                    'gender' => 'male',
                ],
                900
            ],
            // Age > 65
            [
                [
                    'age' => 66,
                    'booking_date' => '2020-10-10 00:00:00',
                    'gender' => 'male',
                ],
                1600
            ],
            // Price in Tuesday
            [
                [
                    'age' => 14,
                    'booking_date' => '2021-05-18 00:00:00',
                    'gender' => 'male',
                ],
                1200
            ],
            // Price in Friday
            [
                [
                    'age' => 14,
                    'booking_date' => '2021-05-21 00:00:00',
                    'gender' => 'female',
                ],
                1400
            ],
        ];
    }
}
