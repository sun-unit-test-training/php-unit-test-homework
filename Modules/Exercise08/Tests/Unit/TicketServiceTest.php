<?php

namespace Modules\Exercise08\Tests;

use Tests\TestCase;
use Modules\Exercise08\Services\TicketService;
use InvalidArgumentException;

class TicketServiceTest extends TestCase
{
    const BASE_PRICE = 1800;
    const PRICE_IN_TUESDAY = 1200;
    const PRICE_FEMALE_FRIDAY = 1400;
    const PRICE_OVER_65 = 1600;
    const MIN_AGE = 0;
    const MAX_AGE = 120;

    protected $ticketService;
    protected $model;

    public function setUp(): void
    {
        parent::setUp();

        $this->ticketService = new TicketService();
    }

    public function test_calculate_price_negative_age()
    {
        $param = [
            'age' => -1,
            'booking_date' => '',
        ];
        $this->expectExceptionMessage('The age must be from ' . self::MIN_AGE . ' to ' . self::MAX_AGE);
        $this->expectException(InvalidArgumentException::class);

        $this->ticketService->calculatePrice($param);
    }

    public function test_calculate_price_age_more_than_120()
    {
        $param = [
            'age' => 121,
            'booking_date' => '',
        ];
        $this->expectExceptionMessage('The age must be from ' . self::MIN_AGE . ' to ' . self::MAX_AGE);
        $this->expectException(InvalidArgumentException::class);

        $this->ticketService->calculatePrice($param);
    }

    public function test_calculate_price_age_equal_0()
    {
        $param = [
            'age' => 0,
            'booking_date' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        $this->assertEquals(self::BASE_PRICE * 0.5, $result);
    }

    public function test_calculate_price_age_less_than_13()
    {
        $param = [
            'age' => 12,
            'booking_date' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        $this->assertEquals(self::BASE_PRICE * 0.5, $result);
    }

    public function test_calculate_price_age_equal_13()
    {
        $param = [
            'age' => 13,
            'booking_date' => '',
            'gender' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        $this->assertEquals(self::BASE_PRICE, $result);
    }

    public function test_calculate_is_tuesday()
    {
        $param = [
            'age' => 13,
            'booking_date' => '2021-04-20',
            'gender' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        $this->assertEquals(self::PRICE_IN_TUESDAY, $result);
    }

    public function test_calculate_is_woman_and_not_friday()
    {
        $param = [
            'age' => 13,
            'booking_date' => '2021-04-21',
            'gender' => config('exercise08.gender.female'),
        ];

        $result = $this->ticketService->calculatePrice($param);
        $this->assertEquals(self::BASE_PRICE, $result);
    }

    public function test_calculate_not_woman_and_friday()
    {
        $param = [
            'age' => 13,
            'booking_date' => '2021-04-23',
            'gender' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        $this->assertEquals(self::BASE_PRICE, $result);
    }

    public function test_calculate_is_woman_and_friday()
    {
        $param = [
            'age' => 13,
            'booking_date' => '2021-04-23',
            'gender' => config('exercise08.gender.female'),
        ];

        $result = $this->ticketService->calculatePrice($param);
        $this->assertEquals(self::PRICE_FEMALE_FRIDAY, $result);
    }

    public function test_calculate_is_woman_and_friday_age_more_than_65()
    {
        $param = [
            'age' => 66,
            'booking_date' => '2021-04-23',
            'gender' => config('exercise08.gender.female'),
        ];

        $result = $this->ticketService->calculatePrice($param);
        $this->assertEquals(self::PRICE_FEMALE_FRIDAY, $result);
    }

    public function test_calculate_age_more_than_65()
    {
        $param = [
            'age' => 66,
            'booking_date' => '2021-04-22',
            'gender' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        $this->assertEquals(self::PRICE_OVER_65, $result);
    }

    public function test_calculate_age_equal_65()
    {
        $param = [
            'age' => 65,
            'booking_date' => '2021-04-22',
            'gender' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        $this->assertEquals(self::BASE_PRICE, $result);
    }
}
