<?php

namespace Modules\Exercise04\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise04\Services\CalendarService;
use Tests\SetupDatabaseTrait;
use Modules\Exercise04\Http\Controllers\CalendarController;

class CalendarControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $calendarServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calendarServiceMock = $this->mock(CalendarService::class);
    }

    function test_it_index_return_view()
    {
        $this->calendarServiceMock
            ->shouldReceive('getDateClass')
            ->andReturn(CalendarService::COLOR_BLACK);

        $url = action([CalendarController::class, 'index']);
        $response = $this->get($url);
        $dataResponse = $response->getOriginalContent()->getData();

        $response->assertViewIs('exercise04::calendar');
        $response->assertViewHas('calendars');
        $this->assertEquals(count($dataResponse["calendars"]), ceil(30/7));
    }
}
