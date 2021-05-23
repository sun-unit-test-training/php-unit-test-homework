<?php

namespace Modules\Exercise04\Tests\Unit\Http\Controllers;

use Modules\Exercise04\Http\Controllers\CalendarController;
use Modules\Exercise04\Services\CalendarService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalendarControllerTest extends TestCase
{
    protected $controller;
    protected $serviceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceMock = $this->mock(CalendarService::class);
        $this->controller = new CalendarController($this->serviceMock);
    }

    public function test_index_success()
    {
        $this->serviceMock->shouldReceive('getDateClass')
            ->andReturn('text-dark');
        $response = $this->controller->index();

        $this->assertEquals('exercise04::calendar', $response->getName());
        $this->assertArrayHasKey('calendars', $response->getData());
    }
}
