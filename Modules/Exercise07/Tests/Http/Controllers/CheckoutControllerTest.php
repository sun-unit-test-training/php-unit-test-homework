<?php
namespace Modules\Exercise07\Tests\Http\Controllers;

use Mockery;
use Tests\TestCase;
use Modules\Exercise07\Services\CheckoutService;
use Modules\Exercise07\Http\Controllers\CheckoutController;
use Illuminate\Contracts\Support\Renderable;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CheckoutControllerTest extends TestCase
{
    public function testConstruct()
    {
        $service = new CheckoutService;
        $controller = new CheckoutController($service);

        $this->assertInstanceOf(CheckoutController::class, $controller);
    }

    public function testIndex()
    {
        $service = new CheckoutService;
        $controller = new CheckoutController($service);

        $this->assertInstanceOf(View::class, $controller->index());
    }

    public function testStore()
    {
        $input = [
            'amount' => 500,
        ];
        $response = [
            'amount' => 500,
            'shipping_fee' => 500,
        ];

        $request = Mockery::mock(CheckoutRequest::class);
        $request->shouldReceive('all')->once()->andReturn($input);

        $service = Mockery::mock(CheckoutService::class);
        $service->shouldReceive('calculateShippingFee')->once()->with($input)->andReturn($response);

        $controller = new CheckoutController($service);

        $this->assertInstanceOf(RedirectResponse::class, $controller->store($request));
    }
}
