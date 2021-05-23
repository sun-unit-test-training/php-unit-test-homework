<?php

namespace Modules\Exercise04\Tests\Unit\Services;

use Modules\Exercise04\Services\CalendarService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;
use Illuminate\Support\Carbon;

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
     * @dataProvider provideDate
     */
    public function test_get_date_class($color, $date)
    {
        $result = $this->calendarService->getDateClass($date, ['2021-05-24']);

        $this->assertEquals($result, $color);
    }

    function provideDate()
    {
        return [
            'Date Is Sunday' => [CalendarService::COLOR_RED, 'date' => Carbon::createFromDate(2021, 5, 23)],
            'Date Is Saturday' => [CalendarService::COLOR_BLUE, 'date' => Carbon::createFromDate(2021, 5, 22)],
            'Date Is A Holiday' => [CalendarService::COLOR_RED, 'date' => Carbon::createFromDate(2021, 5, 24)],
            'Date Is A Normal Day' => [CalendarService::COLOR_BLACK, 'date' => Carbon::createFromDate(2021, 5, 28)],
        ];
    }
}