<?php
namespace Modules\Exercise05\Tests\Http\Controllers;

use Mockery;
use Tests\TestCase;
use Modules\Exercise05\Services\OrderService;
use Modules\Exercise05\Http\Controllers\Exercise05Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class Exercise05ControllerTest extends TestCase
{
    public function testConstruct()
    {
        $service = new OrderService;
        $controller = new Exercise05Controller($service);

        $this->assertInstanceOf(Exercise05Controller::class, $controller);
    }

    public function testIndex()
    {
        $service = new OrderService;
        $controller = new Exercise05Controller($service);

        $this->assertInstanceOf(View::class, $controller->index());
    }

    public function testStore()
    {
        $input = [
            'price' => 1500,
            'option_receive' => '2',
            'option_coupon' => '1',
        ];
        $response = [
            'price' => 1200,
            'discount_pizza' => null,
            'discount_potato' => null,
        ];

        $request = Mockery::mock(OrderRequest::class);
        $request->shouldReceive('only')->once()->andReturn($input);

        $service = Mockery::mock(OrderService::class);
        $service->shouldReceive('handleDiscount')->once()->with($input)->andReturn($response);

        $controller = new Exercise05Controller($service);

        $this->assertInstanceOf(View::class, $controller->store($request));
    }
}
