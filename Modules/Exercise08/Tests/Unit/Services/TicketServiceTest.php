<?php

namespace Modules\Exercise08\Tests\Unit\Services;

use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;
use InvalidArgumentException;

class TicketServiceTest extends TestCase
{
    /**
     * @var TicketService
     */
    protected $ticketService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ticketService = new TicketService();
    }

    /**
     * Test range
     */
    function test_it_throw_exception_when_not_old_enough()
    {
        $this->expectException(InvalidArgumentException::class);
        $data = $this->getSampleData();
        $data['age'] = -1;
        $result = $this->ticketService->calculatePrice($data);

        $this->assertEquals($result, false);
    }

    function test_throw_exception_when_age_over_120_years_old()
    {
        $this->expectException(InvalidArgumentException::class);
        $data = $this->getSampleData();
        $data['age'] = 121;
        $result = $this->ticketService->calculatePrice($data);

        $this->assertEquals($result, false);
    }

    function test_calculate_price_when_age_less_than_13_years_old()
    {
        $data = $this->getSampleData();
        $data['age'] = 10;
        $result = $this->ticketService->calculatePrice($data);

        $this->assertEquals($result, TicketService::BASE_PRICE * 0.5);
    }

    /**
     * Test day of the week
     */
    function test_calculate_price_when_day_of_week_is_tuesday()
    {
        $data = $this->getSampleData();
        $data['booking_date'] = '2021/04/20';
        $result = $this->ticketService->calculatePrice($data);

        $this->assertEquals($result, TicketService::PRICE_IN_TUESDAY);
    }

    function test_calculate_price_when_age_from_13_to_64_not_tuesday_friday()
    {
        $data = $this->getSampleData();
        $data['age'] = 18;
        $data['booking_date'] = '2021/04/24';
        $result = $this->ticketService->calculatePrice($data);

        $this->assertEquals($result, TicketService::BASE_PRICE);
    }

    function test_calculate_price_when_age_from_13_to_64_is_female_on_friday()
    {
        $data = $this->getSampleData();
        $data['age'] = 18;
        $data['gender'] = 'female';
        $data['booking_date'] = '2021/04/23';
        $result = $this->ticketService->calculatePrice($data);

        $this->assertEquals($result, TicketService::PRICE_FEMALE_FRIDAY);
    }

    function test_calculate_price_when_age_from_13_to_64_is_male_on_friday()
    {
        $data = $this->getSampleData();
        $data['age'] = 18;
        $data['gender'] = 'male';
        $data['booking_date'] = '2021/04/23';
        $result = $this->ticketService->calculatePrice($data);

        $this->assertEquals($result, TicketService::BASE_PRICE);
    }

    function test_calculate_price_when_age_over_65_not_tuesday_friday()
    {
        $data = $this->getSampleData();
        $data['age'] = 69;
        $data['gender'] = 'male';
        $data['booking_date'] = '2021/04/22';
        $result = $this->ticketService->calculatePrice($data);

        $this->assertEquals($result, TicketService::PRICE_OVER_65);
    }

    function test_calculate_price_when_age_over_65_is_female_on_friday()
    {
        $data = $this->getSampleData();
        $data['age'] = 69;
        $data['gender'] = 'female';
        $data['booking_date'] = '2021/04/23';
        $result = $this->ticketService->calculatePrice($data);

        $this->assertNotEquals($result, TicketService::PRICE_OVER_65);
        $this->assertEquals($result, TicketService::PRICE_FEMALE_FRIDAY);
    }

    private function getSampleData()
    {
        return [
            'age' => 15,
            'booking_date' => '2021/04/04',
            'gender' => 'female',
            'name' => 'Test'
        ];
    }
}
