<?php

namespace Modules\Exercise04\Tests\Feature\Http\Controllers;

use Carbon\Carbon;
use Modules\Exercise04\Http\Controllers\CalendarController;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
    protected $calendarService;
    protected $calendarController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->calendarService = $this->mock(CalendarService::class);
        $this->calendarController = new CalendarController($this->calendarService);
    }

    public function test_index()
    {
        $day = 0;
        $this->calendarService->shouldReceive('getDateClass')
            ->with(\Mockery::on(function (Carbon $args) use (&$day) {
                return $args->day === ($day++) && $args->year === 2021 && $args->month === 6;
            }), ['2021-06-21'])
            ->times(30)->andReturn(1);
        $response = $this->calendarController->index();

        $this->assertEquals('exercise04::calendar', $response->getName());
        $this->assertArrayHasKey('calendars', $response->getData());
    }
}
