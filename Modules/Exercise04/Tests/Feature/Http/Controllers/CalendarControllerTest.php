<?php

namespace Tests\Feature\Http\Controllers;

use Modules\Exercise04\Http\Controllers\CalendarController;
use Tests\TestCase;
use Modules\Exercise04\Services\CalendarService;
use Tests\SetupDatabaseTrait;

class CalendarControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $calendarServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->calendarServiceMock = $this->mock(CalendarService::class);
    }

    function test_index()
    {
        $url = action([CalendarController::class, 'index']);

        $this->calendarServiceMock->shouldReceive('getDateClass')->andReturn(CalendarService::COLOR_BLACK);

        $response = $this->get($url);

        $response->assertViewIs('exercise04::calendar');
        $response->assertViewHas('calendars');
    }
}
