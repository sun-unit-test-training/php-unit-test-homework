<?php

namespace Tests\Unit\Services;

use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;
use InvalidArgumentException;

class TicketServiceTest extends TestCase
{
    protected $ticketService;

    protected function setUp(): void
    {
        parent::setup();

        $this->ticketService = new TicketService();
    }

    /**
     * @dataProvider provider_data_exception
     */
    public function test_calculate_return_exception($input)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = $this->ticketService->calculatePrice($input);

        $this->assertEquals($result, false);
    }

    public function provider_data_exception()
    {
        return [
            [
                [
                    'age' => -1,
                    'booking_date' => '2021/05/21',
                    'gender' => 'female',
                    'name' => 'Hai'
                ],
                [
                    'age' => 121,
                    'booking_date' => '2021/05/21',
                    'gender' => 'female',
                    'name' => 'Hai'
                ]
            ],
        ];
    }

    /**
     * @dataProvider  provider_data_input
     */
    public function test_calculate_price_return_success($input, $dataPrice)
    {
        $result = $this->ticketService->calculatePrice($input);

        $this->assertEquals($result, $dataPrice);
    }

    public function provider_data_input()
    {
        return [
            [
                [
                    'age' => 10,
                    'booking_date' => '2021/05/21',
                    'gender' => 'female',
                    'name' => 'Hai'
                ],
                TicketService::BASE_PRICE*0.5
            ],
            [
                [
                    'age' => 15,
                    'booking_date' => '2021/05/18',
                    'gender' => 'female',
                    'name' => 'Hai'
                ],
                TicketService::PRICE_IN_TUESDAY
            ],
            [
                [
                    'age' => 15,
                    'booking_date' => '2021/05/19',
                    'gender' => 'female',
                    'name' => 'Test'
                ],
                TicketService::BASE_PRICE
            ],
            [
                [
                    'age' => 15,
                    'booking_date' => '2021/05/21',
                    'gender' => 'female',
                    'name' => 'Test'
                ],
                TicketService::PRICE_FEMALE_FRIDAY
            ],
            [
                [
                    'age' => 15,
                    'booking_date' => '2021/05/21',
                    'gender' => 'male',
                    'name' => 'Test'
                ],
                TicketService::BASE_PRICE
            ],
            [
                [
                    'age' => 100,
                    'booking_date' => '2021/05/21',
                    'gender' => 'male',
                    'name' => 'Test'
                ],
                TicketService::PRICE_OVER_65
            ],
            [
                [
                    'age' => 100,
                    'booking_date' => '2021/05/18',
                    'gender' => 'female',
                    'name' => 'Hai'
                ],
                TicketService::PRICE_IN_TUESDAY
            ],
            [
                [
                    'age' => 100,
                    'booking_date' => '2020/09/25',
                    'gender' => 'female',
                    'name' => 'Test'
                ],
                TicketService::PRICE_FEMALE_FRIDAY
            ],
        ];
    }
}
