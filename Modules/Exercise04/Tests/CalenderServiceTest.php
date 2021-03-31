<?php

namespace Modules\Exercise04\Tests;

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

    public function test_get_date_class_case_normal_date()
    {
        $date = Carbon::createFromDate(2021, 03, 31);

        $response = $this->calendarService->getDateClass($date, $this->holidays);
        $this->assertEquals('text-dark', $response);
    }

    public function test_get_date_class_case_saturday()
    {
        $date = Carbon::createFromDate(2021, 04, 03);

        $response = $this->calendarService->getDateClass($date, $this->holidays);
        $this->assertEquals('text-primary', $response);
    }

    public function test_get_date_class_case_sunday()
    {
        $date = Carbon::createFromDate(2021, 04, 04);

        $response = $this->calendarService->getDateClass($date, $this->holidays);
        $this->assertEquals('text-danger', $response);
    }

    public function test_get_date_class_case_holiday()
    {
        $date = Carbon::createFromDate(2021, 04, 30);

        $response = $this->calendarService->getDateClass($date, $this->holidays);
        $this->assertEquals('text-danger', $response);
    }
}
