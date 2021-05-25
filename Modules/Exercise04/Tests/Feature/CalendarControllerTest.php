<?php

namespace Modules\Exercise04\Tests\Feature;

use Mockery;
use Tests\TestCase;
use Tests\SetupDatabaseTrait;
use Modules\Exercise04\Services\CalendarService;
use Modules\Exercise04\Http\Controllers\CalendarController;

class CalendarControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $calendarService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->calendarService = $this->mock(CalendarService::class);
    }

    function testIndex()
    {
        $this->calendarService->shouldReceive('getDateClass')->andReturn(1);
        $controller = new CalendarController($this->calendarService);

        $view = $controller->index();

        $this->assertEquals('exercise04::calendar', $view->name());
        $this->assertArrayHasKey('calendars', $view->getData());
        $this->assertIsArray($view->getData()['calendars']);
    }
}