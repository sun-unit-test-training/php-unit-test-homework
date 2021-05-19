<?php

namespace Modules\Exercise04\Tests\Feature\Http\Controllers;

use Modules\Exercise04\Http\Controllers\CalendarController;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    protected $calendarServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->calendarServiceMock = $this->mock(CalendarService::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test__contruct()
    {
        $controller = new CalendarController($this->calendarServiceMock);

        $this->assertInstanceOf(CalendarController::class, $controller);
    }

    public function test_index()
    {
        $this->calendarServiceMock->shouldReceive('getDateClass')
            ->andReturn(CalendarService::COLOR_BLUE);
        $url = action([CalendarController::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise04::calendar');
        $response->assertViewHas('calendars');
    }
}
