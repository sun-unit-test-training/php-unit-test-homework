<?php

namespace Modules\Exercise04\Tests\Unit\Http\Services;

use Carbon\Carbon;
use Tests\TestCase;
use Modules\Exercise04\Services\CalendarService;

class CalendarServiceTest extends TestCase
{
    protected $calendarService;
    protected $holidays = ['2021-04-30', '2021-05-01'];

    public function setUp(): void
    {
        parent::setUp();
        $this->calendarService = new CalendarService();
    }

    /**
     * Test getDateClass function with date = sunday
     *
     * @return void
     */
    public function test_get_date_class_with_date_sunday()
    {
        $date = Carbon::createFromDate(2021, 03, 21);

        $response = $this->calendarService->getDateClass($date, $this->holidays);
        $this->assertEquals('text-danger', $response);
    }

    /**
     * Test getDateClass function with date = saturday
     *
     * @return void
     */
    public function test_get_date_class_with_date_saturday()
    {
        $date = Carbon::createFromDate(2021, 03, 20);

        $response = $this->calendarService->getDateClass($date, $this->holidays);
        $this->assertEquals('text-primary', $response);
    }

    /**
     * Test getDateClass function with date = holiday
     *
     * @return void
     */
    public function test_get_date_class_with_date_holiday()
    {
        $date = Carbon::createFromDate(2021, 04, 30);

        $response = $this->calendarService->getDateClass($date, $this->holidays);
        $this->assertEquals('text-danger', $response);
    }

    /**
     * Test getDateClass function with date = weekday
     *
     * @return void
     */
    public function test_get_date_class_with_date_weekday()
    {
        $date = Carbon::createFromDate(2021, 03, 17);

        $response = $this->calendarService->getDateClass($date, $this->holidays);
        $this->assertEquals('text-dark', $response);
    }
}
