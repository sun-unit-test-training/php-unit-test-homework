<?php

namespace Modules\Exercise04\Tests\Unit\Services;

use Carbon\Carbon;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalendarServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CalendarService();
    }


    /**
     * @param $date
     * @param $expectedClass
     * @dataProvider provide_date_data
     */
    public function test_getDateClass($date, $expectedClass)
    {
        $date = Carbon::createFromDate($date);
        $result = $this->service->getDateClass($date, ['2021-04-30', '2021-05-01']);

        $this->assertEquals($expectedClass, $result);
    }

    public function provide_date_data()
    {
        return [
            [
                '2021-05-04',
                CalendarService::COLOR_BLACK
            ],
            [
                '2021-04-30',
                CalendarService::COLOR_RED
            ],
            [
                '2021-05-15',
                CalendarService::COLOR_BLUE
            ],
            [
                '2021-05-01',
                CalendarService::COLOR_RED
            ],
            [
                '2021-05-16',
                CalendarService::COLOR_RED
            ],
        ];
    }
}
