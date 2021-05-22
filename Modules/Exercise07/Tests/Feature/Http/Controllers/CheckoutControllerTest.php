<?php

namespace Tests\Feature\Http\Controllers;

use Modules\Exercise07\Http\Controllers\CheckoutController;
use Tests\TestCase;
use Modules\Exercise07\Services\CheckoutService;
use Tests\SetupDatabaseTrait;

class CheckoutControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->mock(CheckoutService::class);
    }

    function testIndex()
    {
        $url = action([CheckoutController::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise07::checkout.index');
        $response->assertSessionMissing('order');
    }

    public function testStore()
    {
        $input = [
            'amount' => 5000,
            'shipping_express' => false,
            'premium_member' => true,
        ];

        $result = [
            'amount' => 5000,
            'shipping_express' => "off",
            'premium_member' => "on",
            'shipping_fee' => 0,
        ];

        $url = action([CheckoutController::class, 'store']);

        $this->service
            ->shouldReceive('calculateShippingFee')
            ->with($input)
            ->andReturn($result);

        $response = $this->post($url, $input);

        $response->assertSessionHas('order');
    }
}
