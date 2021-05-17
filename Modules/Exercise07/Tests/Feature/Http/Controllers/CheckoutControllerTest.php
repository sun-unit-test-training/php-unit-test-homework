<?php

namespace Tests\Feature\Http\Controllers;

use Modules\Exercise07\Http\Controllers\CheckoutController;
use Tests\TestCase;
use Modules\Exercise07\Services\CheckoutService;
use Tests\SetupDatabaseTrait;

class CheckoutControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $checkoutServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->checkoutServiceMock = $this->mock(CheckoutService::class);
    }

    function test_it_index()
    {
        $url = action([CheckoutController::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise07::checkout.index');
        $response->assertSessionMissing('order');
    }

    public function test_store()
    {
        $input = [
            'amount' => 1000,
            'premium_member' => true,
            'premium_member' => true,
        ];

        $result = [
            'amount' => 1000,
            'shipping_express' => "on",
            'premium_member' => "on",
            'shipping_fee' => 500,
        ];

        $url = action([CheckoutController::class, 'store']);

        $this->checkoutServiceMock
            ->shouldReceive('calculateShippingFee')
            ->with($input)
            ->andReturn($result);

        $response = $this->post($url, $input);

        $response->assertSessionHas('order', function ($order) {
            return $order['amount'] == 1000 && $order['shipping_express'] == 'on' && $order['premium_member'] == 'on' && $order['shipping_fee'] == 500;
        });
    }
}
