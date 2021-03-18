<?php

namespace Modules\Exercise04\Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise04\Services\CalendarService;
use Modules\Exercise04\Http\Controllers\CalendarController;

class CalendarControllerTest extends TestCase
{
    protected $calendarService;
    protected $calendarController;

    public function setUp(): void
    {
        parent::setUp();
        $this->calendarService = $this->mock(CalendarService::class);
        $this->calendarController = new CalendarController($this->calendarService);
    }

    /**
     * Test index function.
     *
     * @return void
     */
    public function test_index()
    {
        $this->calendarService->shouldReceive('getDateClass')->times(30);

        $response = $this->calendarController->index();
        $this->assertEquals('exercise04::calendar', $response->getName());
    }
}
