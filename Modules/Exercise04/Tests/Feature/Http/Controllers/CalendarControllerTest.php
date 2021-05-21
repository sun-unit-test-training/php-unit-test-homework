<?php

namespace Modules\Exercise01\Tests\Feature\Http\Controllers;

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
        $this->calendarService->shouldReceive('getDateClass')->andReturn(1);
        $response = $this->calendarController->index();

        $this->assertEquals('exercise04::calendar', $response->getName());
        $this->assertArrayHasKey('calendars', $response->getData());
    }
}