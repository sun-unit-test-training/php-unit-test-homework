<?php

namespace Modules\Exercise04\Tests\Unit\Services;

use Modules\Exercise04\Services\CalendarService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;
use Illuminate\Support\Carbon;

class CalendarServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CalendarService();
    }

    /**
     * @dataProvider provideDate
     */
    public function testGetDateClass($color, $date)
    {
        $result = $this->service->getDateClass($date, ['2020-09-26']);

        $this->assertEquals($result, $color);
    }

    function provideDate()
    {
        return [
            [CalendarService::COLOR_RED, 'date' => Carbon::createFromDate(2020, 9, 13)],
            [CalendarService::COLOR_BLUE, 'date' => Carbon::createFromDate(2020, 9, 12)],
            [CalendarService::COLOR_RED, 'date' => Carbon::createFromDate(2020, 9, 26)],
            [CalendarService::COLOR_BLACK, 'date' => Carbon::createFromDate(2020, 9, 30)],
        ];
    }
}
