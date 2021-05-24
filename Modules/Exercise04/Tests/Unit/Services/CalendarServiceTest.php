<?php

namespace Modules\Exercise04\Tests\Unit\Services;

use Carbon\Carbon;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;

class CalendarServiceTest extends TestCase
{
    public function test_get_date_class_function_with_sunday_input()
    {
        // Sunday Input
        $date = Carbon::create(2021, 5, 16);

        $calendarService = new CalendarService();
        $result = $calendarService->getDateClass($date, []);

        $this->assertEquals(CalendarService::COLOR_RED, $result);
    }

    public function test_get_date_class_function_with_saturday_input()
    {
        // Saturday Input
        $date = Carbon::create(2021, 5, 15);

        $calendarService = new CalendarService();
        $result = $calendarService->getDateClass($date, []);

        $this->assertEquals(CalendarService::COLOR_BLUE, $result);
    }

    public function test_get_date_class_function_with_holidays_input()
    {
        // Holidays input
        $date = Carbon::create(2021, 5, 10);
        $holidays = ['2021-05-10'];

        $calendarService = new CalendarService();
        $result = $calendarService->getDateClass($date, $holidays);

        $this->assertEquals(CalendarService::COLOR_RED, $result);
    }

    public function test_get_date_class_function_with_day_of_week_input()
    {
        // Monday input
        $date = Carbon::create(2021, 5, 24);

        $calendarService = new CalendarService();
        $result = $calendarService->getDateClass($date, []);

        $this->assertEquals(CalendarService::COLOR_BLACK, $result);
    }
}
