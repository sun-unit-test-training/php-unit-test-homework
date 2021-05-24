<?php

namespace Modules\Tests\Exercise06\Tests\Feature\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Exercise07\Http\Controllers\CheckoutController;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    private $controller;
    private $mockCheckoutService;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockCheckoutService = $this->mock(CheckoutService::class);
        $this->controller = new CheckoutController($this->mockCheckoutService);
    }

    public function testIndex()
    {
        $response = $this->controller->index();
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('exercise07::checkout.index', $response->getName());
    }

    public function testStore()
    {
        $order = [
            'amount' => 1000,
            'shipping_express' => true,
        ];

        $mockRequest = $this->mock(CheckoutRequest::class);
        $mockRequest->shouldReceive('all')
            ->andReturn($order);

        $this->mockCheckoutService->shouldReceive('calculateShippingFee')
            ->with($order)
            ->andReturn([]);

        $res = $this->controller->store($mockRequest);
        $this->assertInstanceOf(RedirectResponse::class, $res);
    }
}
