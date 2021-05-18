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
     * @dataProvider provider_return_class
     */
    public function test_get_date_class($date, $class)
    {
        $response = $this->calendarService->getDateClass($date, ['2020-09-26']);

        $this->assertEquals($class, $response);
    }

    public function provider_return_class()
    {
        return [
            [
                Carbon::createFromDate(2020, 9, 5),
                CalendarService::COLOR_BLUE
            ],
            [
                Carbon::createFromDate(2020, 9, 6),
                CalendarService::COLOR_RED
            ],
            [
                Carbon::createFromDate(2020, 9, 7),
                CalendarService::COLOR_BLACK
            ],
            [
                Carbon::createFromDate(2020, 9, 26),
                CalendarService::COLOR_RED
            ],
        ];
    }
}
