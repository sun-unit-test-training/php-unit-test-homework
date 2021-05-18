<?php

namespace Tests\Feature\Http\Controllers;

use Modules\Exercise04\Http\Controllers\CalendarController;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
    protected $calendarService;
    protected $calendarController;

    protected function setUp(): void
    {
        parent::setup();

        $this->calendarService = $this->mock(CalendarService::class);
        $this->calendarController = new CalendarController(
            $this->calendarService
        );
    }
    public function test_index_show_calendar_view_success()
    {
        $expected = CalendarService::COLOR_BLACK;
        $this->calendarService->shouldReceive('getDateClass')->andReturn($expected);
        $response = $this->calendarController->index();

        $this->assertEquals('exercise04::calendar', $response->getName());
        $this->assertArrayHasKey('calendars', $response->getData());
    }
}
