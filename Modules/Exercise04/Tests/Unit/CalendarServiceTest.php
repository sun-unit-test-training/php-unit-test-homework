<?php

namespace Modules\Exercise04\Tests\Unit;

use Tests\TestCase;
use Modules\Exercise04\Services\CalendarService;
use Illuminate\Support\Carbon;

class CalendarServiceTest extends TestCase
{
    private $calendarService;

    public function setUp(): void
    {
        parent::setUp();
        $this->calendarService = new CalendarService();
    }

    public function providerValidData()
    {
        return [
            [
                Carbon::createFromDate('2021','03','26'),
                [],
                CalendarService::COLOR_BLACK,
            ],
            [
                Carbon::createFromDate('2021','03','28'),
                [],
                CalendarService::COLOR_RED,
            ],
            [
                Carbon::createFromDate('2021','03','27'),
                [],
                CalendarService::COLOR_BLUE,
            ],
            [
                Carbon::createFromDate('2021','03','28'),
                ['2021-03-28'],
                CalendarService::COLOR_RED,
            ],
        ];
    }

    /**
     * @dataProvider providerValidData
     */
    public function test_getDateClass($date, $holidays, $color)
    {
        $result = $this->calendarService->getDateClass($date, $holidays);

        $this->assertEquals($color, $result);
    }
}
