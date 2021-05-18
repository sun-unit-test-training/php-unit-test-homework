<?php

namespace Tests\Unit\Services;

use Carbon\Carbon;
use InvalidArgumentException;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;

class CalendarServiceTest extends TestCase
{
    protected $calendarService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->calendarService = new CalendarService();
    }

    /**
     * @param $date
     * @param $expectedValue
     * @dataProvider provideData
     * */
    public function test_get_date_class($date, $expectedValue)
    {
        $holidays = ['2021-05-19'];

        $class = $this->calendarService->getDateClass($date, $holidays);
        $this->assertEquals($expectedValue, $class);
    }

    public function provideData()
    {
        return [
            'Normal_day' => [
                Carbon::createFromDate(2021, 05, 18),
                CalendarService::COLOR_BLACK
            ],
            'Holiday' => [
                Carbon::createFromDate(2021, 05, 19),
                CalendarService::COLOR_RED
            ],
            'Saturday' => [
                Carbon::createFromDate(2021, 05, 22),
                CalendarService::COLOR_BLUE
            ],
            'Sunday' => [
                Carbon::createFromDate(2021, 05, 23),
                CalendarService::COLOR_RED
            ],
        ];
    }
}
