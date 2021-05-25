<?php

namespace Modules\Exercise04\Tests;

use Carbon\Carbon;
use Modules\Exercise04\Services\CalendarService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class CalendarServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $calendarService;

    public function setUp(): void
    {
        parent::setUp();

        $this->calendarService = new CalendarService();
    }

    /**
     * @dataProvider dateForClass
     * @param $date
     * @param $holidays
     * @param $resultClass
     */
    public function testGetDateClass($date, $holidays, $resultClass)
    {
        $date = Carbon::createFromDate($date);
        $class = $this->calendarService->getDateClass($date, $holidays);
        $this->assertEquals($resultClass, $class);
    }

    public function dateForClass()
    {
        return [
            [
                '2020-05-10',
                ['2020-05-02'],
                CalendarService::COLOR_RED,
            ],
            [
                '2021-04-12',
                ['2020-04-02'],
                CalendarService::COLOR_BLACK
            ],
            [
                '2020-04-29',
                ['2020-04-29'],
                CalendarService::COLOR_RED,
            ],
            [
                '2020-04-11',
                ['2020-04-02'],
                CalendarService::COLOR_BLUE,
            ],
        ];
    }
}