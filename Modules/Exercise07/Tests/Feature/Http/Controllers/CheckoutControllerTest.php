<?php

namespace Modules\Exercise07\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise07\Http\Controllers\CheckoutController;
use Modules\Exercise07\Services\CheckoutService;
use Tests\SetupDatabaseTrait;
use Modules\Exercise07\Http\Requests\CheckoutRequest;

class CheckoutControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
    }

    function test_it_index_return_view()
    {
        $url = action([CheckoutController::class, 'index']);
        $response = $this->get($url);

        $response->assertViewIs('exercise07::checkout.index');
    }

    function test_it_store()
    {
        $request = $this->mock(CheckoutRequest::class);
        $request->shouldReceive('all')->andReturn([
            'amount' => 1
        ]);

        $checkoutServiceMock = $this->mock(CheckoutService::class);
        $checkoutServiceMock->shouldReceive('calculateShippingFee')
            ->andReturn([
                'amount' => 1,
                'shipping_fee' => 1
            ]);

        $url = action([CheckoutController::class, 'store']);
        $response = $this->post($url);

        $response->assertRedirect();
        $this->assertEquals([
                'amount' => 1,
                'shipping_fee' => 1
            ], $response->getSession()->all()['order']);
    }
}
