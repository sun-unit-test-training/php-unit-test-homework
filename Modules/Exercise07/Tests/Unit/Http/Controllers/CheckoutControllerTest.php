<?php

namespace Modules\Exercise07\Tests\Unit\Http\Controllers;

use Modules\Exercise07\Http\Controllers\CheckoutController;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    private $checkoutService;
    protected $checkoutController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->checkoutService = $this->mock(CheckoutService::class);
        $this->checkoutController = new CheckoutController($this->checkoutService);
    }

    public function test__construct()
    {
        $controller = new CheckoutController($this->checkoutService);

        $this->assertInstanceOf(CheckoutController::class, $controller);

    }

    public function test_index_return_view()
    {
        $view = $this->checkoutController->index();

        $this->assertEquals('exercise07::checkout.index', $view->name());
    }

    public function test_store()
    {
        $formRequest = ['amount' => 1];
        $expectOrder = ['order'];
        $this->checkoutService
            ->shouldReceive('calculateShippingFee')
            ->with($formRequest)
            ->andReturn($expectOrder);

        $mockRequest = $this->mock(CheckoutRequest::class);
        $mockRequest->shouldReceive('all')->andReturn($formRequest);
        $response = $this->checkoutController->store($mockRequest);

        $this->assertEquals($expectOrder, $response->getSession()->get('order'));
    }
}
