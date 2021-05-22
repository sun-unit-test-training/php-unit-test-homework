<?php

namespace Modules\Exercise07\Tests\Feature\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Mockery\MockInterface;
use Modules\Exercise07\Http\Controllers\CheckoutController;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    /**
     * @var MockInterface
     */
    protected $controller;
    protected $checkoutService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->checkoutService = $this->mock(CheckoutService::class);
        $this->controller = new CheckoutController($this->checkoutService);
    }

    public function test_index()
    {
        $response = $this->controller->index();

        $this->assertEquals('exercise07::checkout.index', $response->getName());
    }

    public function test_store()
    {
        $inputs = [
            'amount' => 99,
        ];
        $expected = ['shipping_fee' => 10];

        $request = CheckoutRequest::create('', 'post', $inputs);

        $this->checkoutService->shouldReceive('calculateShippingFee')
            ->with($inputs)
            ->once()
            ->andReturn($expected);

        $response = $this->controller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals($expected, $response->getSession()->get('order'));
    }
}
