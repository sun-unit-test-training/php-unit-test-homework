<?php

namespace Modules\Exercise04\Tests;

use Carbon\Carbon;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;

class CalendarServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CalendarService();
    }

    public function test_property()
    {
        $this->assertEquals('text-dark', CalendarService::COLOR_BLACK);
        $this->assertEquals('text-danger', CalendarService::COLOR_RED);
        $this->assertEquals('text-primary', CalendarService::COLOR_BLUE);
    }

    /**
     * @dataProvider date_for_get_class
     * @param $date
     * @param $holiday
     * @param $expectedClass
     */
    public function test_get_date_class($date, $holiday, $expectedClass)
    {
        $date = Carbon::createFromDate($date);
        $class = $this->service->getDateClass($date, $holiday);
        $this->assertEquals($expectedClass, $class);
    }

    public function date_for_get_class()
    {
        return [
            [
                '2021-02-07',
                ['2021-02-02'],
                'text-danger',
            ],
            [
                '2021-02-06',
                ['2021-02-02'],
                'text-primary',
            ],
            [
                '2021-03-29',
                ['2021-03-29'],
                'text-danger',
            ],
            [
                '2021-02-03',
                ['2021-03-29'],
                'text-dark',
            ],
        ];
    }
}
