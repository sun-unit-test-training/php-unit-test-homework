<?php

namespace Modules\Tests\Exercise03\Tests\Http\Services;

use Carbon\Carbon;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;

class CalendarServiceTest extends TestCase
{
    private $calendarService;

    public function setUp(): void
    {
        parent::setUp();
        $this->calendarService = new CalendarService();
    }

    /**
     * @param $date
     * @dataProvider provideData
     */
    public function testGetDateClass($date, $expectValue)
    {
        $holiday = ['2021-05-30'];

        $class = $this->calendarService->getDateClass($date, $holiday);
        $this->assertEquals($class, $expectValue);
    }

    public function provideData()
    {
        return [
            [
                Carbon::createFromDate(2021, 5, 23),
                CalendarService::COLOR_RED,
            ],
            [
                Carbon::createFromDate(2021, 5, 29),
                CalendarService::COLOR_BLUE,
            ],
            [
                Carbon::createFromDate(2021, 5, 30),
                CalendarService::COLOR_RED,
            ],

        ];
    }
}
