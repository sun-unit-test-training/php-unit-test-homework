<?php

namespace Modules\Exercise04\Tests\Unit\Http\Controllers;

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

    public function test__construct()
    {
        $controller = new CalendarController($this->calendarService);

        $this->assertInstanceOf(CalendarController::class, $controller);

    }

    public function test_index()
    {
        $this->calendarService->shouldReceive('getDateClass')->andReturn(1);
        $view = $this->calendarController->index();

        $this->assertEquals('exercise04::calendar', $view->name());
        $this->assertArrayHasKey('calendars', $view->getData());
        $this->assertIsArray($view->getData()['calendars']);
    }
}
