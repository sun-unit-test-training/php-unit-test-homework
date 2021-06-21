<?php

namespace Modules\Exercise04\Tests\Unit\Services;

use Carbon\Carbon;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;

class CalendarServiceTest extends TestCase
{
    protected $calendarService;

    protected function setUp(): void
    {
        parent::setup();

        $this->calendarService = new CalendarService();
    }

    /**
     * @dataProvider provider_get_date_class
     */
    public function test_get_date_class($date, $class)
    {
        $response = $this->calendarService->getDateClass($date, ['2021-05-14']);

        $this->assertEquals($class, $response);
    }

    function provider_get_date_class()
    {
        return [
            [
                Carbon::createFromFormat('Y-m-d', '2021-05-16'),
                CalendarService::COLOR_RED,
            ],
            [
                Carbon::createFromFormat('Y-m-d', '2021-05-15'),
                CalendarService::COLOR_BLUE,
            ],
            [
                Carbon::createFromFormat('Y-m-d', '2021-05-14'),
                CalendarService::COLOR_RED,
            ],
            [
                Carbon::createFromFormat('Y-m-d', '2021-06-21'),
                CalendarService::COLOR_BLACK,
            ],
        ];
    }

    public function test_get_date_class_saturday_is_holiday()
    {
        $response = $this->calendarService->getDateClass(
            Carbon::createFromFormat('Y-m-d', '2021-06-19'),
            ['2021-06-19']
        );

        $this->assertEquals(CalendarService::COLOR_RED, $response);
    }
}
