<?php

namespace Modules\Exercise04\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise04\Services\CalendarService;
use Tests\SetupDatabaseTrait;
use Modules\Exercise04\Http\Controllers\CalendarController;
use Carbon\Carbon;

class CalendarControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = \Mockery::mock(CalendarService::class);
    }

    function testIndex()
    {
        $response = $this->get(route('calendar'));
        $response->assertStatus(200);
        $response->assertViewIs('exercise04::calendar');

        $this->service
            ->shouldReceive('getDateClass')
            ->with(Carbon::parse('2020-09-01'), ['2020-09-25'])
            ->andReturn(CalendarService::COLOR_BLACK);

        $response = $this->get(action([CalendarController::class, 'index']));

        $response->assertViewIs('exercise04::calendar');
        $response->assertViewHas('calendars');
    }
}
