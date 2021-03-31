<?php

namespace Modules\Exercise04\Tests;

use Mockery as m;
use Tests\TestCase;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Modules\Exercise04\Services\CalendarService;
use Modules\Exercise04\Http\Controllers\CalendarController;

class CalendarControllerTest extends TestCase
{
    protected $calendarService;
    protected $calendarController;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockCalendarService = m::mock(CalendarService::class)->makePartial();
        $this->calendarController = new CalendarController($this->mockCalendarService);
    }

    public function test_index()
    {
        $this->mockCalendarService->shouldReceive('getDateClass')->times(30);
        $response = $this->calendarController->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('exercise04::calendar', $response->getName());
    }
}
