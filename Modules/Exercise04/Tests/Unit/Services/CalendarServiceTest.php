<?php

namespace Tests\Unit\Services;

use Carbon\Carbon;
use Modules\Exercise04\Services\CalendarService;
use PHPUnit\Framework\TestCase;

class CalendarServiceTest extends TestCase
{
    protected $calendarService;

    protected function setUp(): void
    {
        parent::setup();

        $this->calendarService = new CalendarService();
    }

    /**
     * @dataProvider provider_date_input_data
     */
    public function test_get_date_class($date, $expected)
    {
        $response = $this->calendarService->getDateClass($date, ['2021-04-30']);

        $this->assertEquals($expected, $response);
    }

    public function provider_date_input_data()
    {
        return [
            [
                Carbon::createFromDate(2021, 5, 5),
                CalendarService::COLOR_BLACK
            ],
            [
                Carbon::createFromDate(2021, 5, 23),
                CalendarService::COLOR_RED
            ],
            [
                Carbon::createFromDate(2021, 5, 22),
                CalendarService::COLOR_BLUE
            ],
            [
                Carbon::createFromDate(2021, 4, 30),
                CalendarService::COLOR_RED
            ],
        ];
    }
}
