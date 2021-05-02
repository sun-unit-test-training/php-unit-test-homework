<?php

namespace Modules\Exercise04\Tests;
use Modules\Exercise04\Http\Controllers\CalendarController;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;
use Mockery;

class CalendarControllerTest extends TestCase
{
    public function test__construct()
    {
        $service = Mockery::mock(CalendarService::class);
        $controller = new CalendarController($service);
        $repositoryRef = $this->getHiddenProperty($controller, 'calendarService');
        $this->assertSame($service, $repositoryRef->getValue($controller));
    }

    public function test_index()
    {
        $response = $this->get(route('calendar'));
        $calendarsResponse = $response->viewData('calendars');
        $response->assertStatus(200);
        $response->assertViewIs('exercise04::calendar');

        $this->assertEquals(1, $calendarsResponse[0][0]['label']);
        $this->assertEquals('text-dark', $calendarsResponse[0][0]['class']);
        $this->assertEquals('2020-09-01', $calendarsResponse[0][0]['date']->toDateString());

        $this->assertEquals(30, $calendarsResponse[4][1]['label']);
        $this->assertEquals('text-dark', $calendarsResponse[4][1]['class']);
        $this->assertEquals('2020-09-30', $calendarsResponse[4][1]['date']->toDateString());
    }
}
