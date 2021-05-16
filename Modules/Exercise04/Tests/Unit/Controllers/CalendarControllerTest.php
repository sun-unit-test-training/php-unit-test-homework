<?php

namespace Modules\Exercise04\Tests\Unit\Controllers;

use Mockery\MockInterface;
use Modules\Exercise04\Http\Controllers\CalendarController;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
    public function test_index()
    {
        $calendarService = $this->mock(CalendarService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getDateClass')
                ->andReturn('DataClass Return');
        });

        $controller = new CalendarController($calendarService);

        $view = $controller->index();

        $this->assertEquals('exercise04::calendar', $view->name());
        $this->assertArrayHasKey('calendars', $view->getData());
        $this->assertIsArray($view->getData()['calendars']);
    }
}
