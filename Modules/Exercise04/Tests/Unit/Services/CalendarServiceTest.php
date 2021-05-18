<?php

namespace Tests\Unit\Services;

use Carbon\Carbon;
use Tests\TestCase;
use Modules\Exercise04\Services\CalendarService;

class CalendarServiceTest extends TestCase
{
    protected $calendarServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CalendarService();
    }

    /**
     * @dataProvider provider_test_get_date_class
     */
    public function test_get_date_class($date, $class)
    {
        $holidays = ['2020-09-26'];
        $response = $this->service->getDateClass($date, $holidays);

        $this->assertEquals($class, $response);
    }

    public function provider_test_get_date_class()
    {
        return [
            [
                Carbon::createFromDate(2020, 9, 5),
                'text-primary'
            ],
            [
                Carbon::createFromDate(2020, 9, 6),
                'text-danger'
            ],
            [
                Carbon::createFromDate(2020, 9, 7),
                'text-dark'
            ],
            [
                Carbon::createFromDate(2020, 9, 26),
                'text-danger'
            ],
        ];
    }
}
