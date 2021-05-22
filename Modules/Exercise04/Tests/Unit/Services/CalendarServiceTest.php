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
     * @dataProvider provideData
     */
    public function test_get_date_class($date, $class)
    {
        $response =$this->calendarService->getDateClass($date, ['2021-05-20']);

        $this->assertEquals($class, $response);
    }

    function provideData()
    {
        return [
            [
                Carbon::createFromFormat('Y-m-d', '2021-05-23'),
                CalendarService::COLOR_RED,
            ],
            [
                Carbon::createFromFormat('Y-m-d', '2021-05-22'),
                CalendarService::COLOR_BLUE,
            ],
            [
                Carbon::createFromFormat('Y-m-d', '2021-05-20'),
                CalendarService::COLOR_RED,
            ],
        ];
    }
}
