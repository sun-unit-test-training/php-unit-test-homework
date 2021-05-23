<?php

namespace Modules\Exercise04\Tests\Feature;

use Modules\Exercise04\Http\Controllers\CalendarController;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
    private $calendarService;

    public function setUp(): void
    {
        parent::setUp();
        $this->calendarService = $this->mock(CalendarService::class);
    }

    public function test_show_index()
    {
        $url = action([CalendarController::class, 'index']);
        $this->calendarService->shouldReceive('getDateClass')->andReturn('123');

        $response = $this->get($url);

        $response->assertViewIs('exercise04::calendar');
        $response->assertViewHas('calendars');
    }
}
