<?php
namespace Modules\Exercise04\Tests\Http\Controllers;

use Mockery;
use Tests\TestCase;
use Modules\Exercise04\Services\CalendarService;
use Modules\Exercise04\Http\Controllers\CalendarController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class CalendarControllerTest extends TestCase
{
    public function testConstruct()
    {
        $service = new CalendarService;
        $controller = new CalendarController($service);

        $this->assertInstanceOf(CalendarController::class, $controller);
    }

    public function testIndex()
    {
        $service = Mockery::mock(CalendarService::class);
        $service->shouldReceive('getDateClass')->times(30)->andReturn('any_color');

        $controller = new CalendarController($service);
        $this->assertInstanceOf(View::class, $controller->index());
    }
}
