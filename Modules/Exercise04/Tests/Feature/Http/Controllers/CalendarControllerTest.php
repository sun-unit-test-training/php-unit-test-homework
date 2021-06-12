<?php

namespace Modules\Exercise04\Tests\Feature\Http\Controllers;

use Carbon\Carbon;
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
        $day = 0;
        $this->calendarServiceMock
            ->shouldReceive('getDateClass')
            ->with(\Mockery::on(function (Carbon $args) use (&$day) {
                return $args->day === ($day++) && $args->year === 2020 && $args->month === 9;
            }), ['2020-09-26'])
            ->times(30)
            ->andReturn(CalendarService::COLOR_BLACK);

        $url = action([CalendarController::class, 'index']);
        $response = $this->get($url);
        $dataResponse = $response->getOriginalContent()->getData();

        $response->assertViewIs('exercise04::calendar');
        $response->assertViewHas('calendars', $dataResponse["calendars"]);

        $this->assertEquals(count($dataResponse["calendars"][0]), 7);
        $this->assertEquals(count($dataResponse["calendars"]), ceil(30/7));
        $this->assertTrue(array_key_exists(4, $dataResponse["calendars"]));
    }
}
