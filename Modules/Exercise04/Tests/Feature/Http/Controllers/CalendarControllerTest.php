<?php

namespace Tests\Feature\Http\Controllers;

use Modules\Exercise04\Http\Controllers\CalendarController;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
    protected $controller;
    protected $calendarService;

    protected function setUp(): void
    {
        parent::setup();

        $this->calendarService = $this->mock(CalendarService::class);
        $this->controller = new CalendarController($this->calendarService);
    }

    public function test_index()
    {
        $this->calendarService->shouldReceive('getDateClass')
            ->andReturn(CalendarService::COLOR_BLACK);
        $response = $this->controller->index();

        $this->assertEquals('exercise04::calendar', $response->getName());
        $this->assertArrayHasKey('calendars', $response->getData());
    }
}
