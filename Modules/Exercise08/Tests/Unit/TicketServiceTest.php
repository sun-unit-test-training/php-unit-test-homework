<?php

namespace Modules\Exercise08\Tests\Unit;

use InvalidArgumentException;
use Tests\TestCase;
use Modules\Exercise08\Services\TicketService;

class TicketServiceTest extends TestCase
{
    private $ticketService;

    public function setUp(): void
    {
        parent::setUp();
        $this->ticketService = new TicketService();
    }

    public function providerInvalidDataAge()
    {
        return [
            [
                [
                    'booking_date' => '26-03-2021',
                    'age' => -1,
                ],
                [
                    'booking_date' => '26-03-2021',
                    'age' => 121,
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerInvalidDataAge
     */
    public function test_calculatePrice_exception_when_input_age_invalid($inputs)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->ticketService->calculatePrice($inputs);
    }

    public function providerValidData()
    {
        return [
            [
                [
                    'booking_date' => '26-03-2021',
                    'age' => 12,
                ],
                900
            ],
            [
                [
                    'booking_date' => '18-05-2021',
                    'age' => 13,
                ],
                1200
            ],
            [
                [
                    'gender' => 'female',
                    'booking_date' => '26-03-2021',
                    'age' => 13,
                ],
                1400
            ],
            [
                [
                    'gender' => 'female',
                    'booking_date' => '26-03-2021',
                    'age' => 66,
                ],
                1400
            ],
            [
                [
                    'gender' => 'female',
                    'booking_date' => '25-03-2021',
                    'age' => 13,
                ],
                1800
            ],
            [
                [
                    'gender' => 'female',
                    'booking_date' => '25-03-2021',
                    'age' => 66,
                ],
                1600
            ],
            [
                [
                    'gender' => 'male',
                    'booking_date' => '26-03-2021',
                    'age' => 13,
                ],
                1800
            ],
            [
                [
                    'gender' => 'male',
                    'booking_date' => '25-03-2021',
                    'age' => 13,
                ],
                1800
            ],
            [
                [
                    'gender' => 'male',
                    'booking_date' => '26-03-2021',
                    'age' => 66,
                ],
                1600
            ],
            [
                [
                    'gender' => 'male',
                    'booking_date' => '25-03-2021',
                    'age' => 66,
                ],
                1600
            ],
        ];
    }

    /**
     * @dataProvider providerValidData
     */
    public function test_calculatePrice($inputs, $expectedPrice)
    {
        $result = $this->ticketService->calculatePrice($inputs);

        $this->assertEquals($expectedPrice, $result);
    }
}
