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
    public function test_function_get_date_class($date, $class)
    {

        $response = $this->calendarService->getDateClass($date, ['2021-05-04']);

        $this->assertEquals($class, $response);
    }

    public function provider_return_class()
    {
        return [
            [
                Carbon::createFromDate(2021, 5, 1),
                CalendarService::COLOR_BLUE
            ],
            [
                Carbon::createFromDate(2021, 5, 2),
                CalendarService::COLOR_RED
            ],
            [
                Carbon::createFromDate(2021, 5, 4),
                CalendarService::COLOR_RED
            ],
            [
                Carbon::createFromDate(2021, 5, 5),
                CalendarService::COLOR_BLACK
            ],
        ];
    }
}