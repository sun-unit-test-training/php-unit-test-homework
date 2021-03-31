<?php

namespace Modules\Exercise07\Tests;

use Mockery as m;
use Tests\TestCase;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Modules\Exercise07\Services\CheckoutService;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Modules\Exercise07\Http\Controllers\CheckoutController;

class CheckoutControllerTest extends TestCase
{
    protected $checkoutService;
    protected $checkoutController;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockCheckoutService = m::mock(CheckoutService::class)->makePartial();
        $this->checkoutController = new CheckoutController($this->mockCheckoutService);
    }

    public function test_index()
    {
        $response = $this->checkoutController->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('exercise07::checkout.index', $response->getName());
    }

    public function test_store_success()
    {
        $request = new CheckoutRequest();

        $this->mockCheckoutService->shouldReceive('calculateShippingFee')
            ->with($request->all())
            ->once()
            ->andReturn(200);

        $result = $this->checkoutController->store($request);
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertTrue(Session::has('order'));
    }
}
