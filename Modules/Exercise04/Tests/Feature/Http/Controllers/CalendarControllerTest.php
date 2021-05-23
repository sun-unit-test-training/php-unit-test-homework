<?php

namespace Modules\Tests\Exercise04\Tests\Http\Controllers;

use Illuminate\View\View;
use Modules\Exercise04\Http\Controllers\CalendarController;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
    private $calendarController;
    private $mockCalendarService;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockCalendarService = $this->mock(CalendarService::class);
        $this->calendarController = new CalendarController($this->mockCalendarService);
    }

    public function testIndex()
    {
        $this->mockCalendarService
            ->shouldReceive('getDateClass')
            ->andReturn(CalendarService::COLOR_BLUE);

        $response = $this->calendarController->index();
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('exercise04::calendar', $response->getName());
    }

}
