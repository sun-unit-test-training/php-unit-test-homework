<?php
namespace Modules\Exercise06\Tests\Http\Controllers;

use Mockery;
use Tests\TestCase;
use Modules\Exercise06\Services\CalculateService;
use Modules\Exercise06\Http\Controllers\Exercise06Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class Exercise06ControllerTest extends TestCase
{
    public function testConstruct()
    {
        $service = new CalculateService;
        $controller = new Exercise06Controller($service);

        $this->assertInstanceOf(Exercise06Controller::class, $controller);
    }

    public function testIndex()
    {
        $service = new CalculateService;
        $controller = new Exercise06Controller($service);

        $this->assertInstanceOf(View::class, $controller->index());
    }

    public function testStore()
    {
        $input = [
            'bill' => 1500,
            'has_watch' => true,
        ];
        $response = 60;

        $request = Mockery::mock(Exercise06Request::class);
        $request->shouldReceive('validated')->once()->andReturn($input);

        $service = Mockery::mock(CalculateService::class);
        $service->shouldReceive('calculate')->once()->with(1500, true)->andReturn($response);

        $controller = new Exercise06Controller($service);

        $this->assertInstanceOf(RedirectResponse::class, $controller->calculate($request));
    }
}
