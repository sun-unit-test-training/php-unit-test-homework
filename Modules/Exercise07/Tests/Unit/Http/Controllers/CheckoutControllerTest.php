<?php

namespace Modules\Exercise07\Tests\Unit\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Exercise07\Http\Controllers\CheckoutController;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Modules\Exercise07\Services\CheckoutService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutControllerTest extends TestCase
{
    protected $controller;
    protected $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serviceMock = $this->mock(CheckoutService::class);
        $this->controller = new CheckoutController($this->serviceMock);
    }

    public function test_index_return_view()
    {
        $response = $this->controller->index();

        $this->assertEquals('exercise07::checkout.index', $response->getName());
    }

    public function test_store()
    {
        $inputs = [
            'amount' => 5000,
        ];
        $expected = ['shipping_fee' => 0];

        $request = CheckoutRequest::create('', 'POST', $inputs);

        $this->serviceMock->shouldReceive('calculateShippingFee')
            ->with($inputs)
            ->once()
            ->andReturn($expected);

        $response = $this->controller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertArrayHasKey('shipping_fee', $response->getSession()->get('order'));
    }
}
