<?php

namespace Modules\Exercise07\Tests\Feature;

use Mockery;
use Tests\TestCase;
use Tests\SetupDatabaseTrait;
use Illuminate\Http\RedirectResponse;
use Modules\Exercise07\Services\CheckoutService;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Modules\Exercise07\Http\Controllers\CheckoutController;

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
        $controller = new CheckoutController($this->service);

        $view = $controller->index();

        $this->assertEquals('exercise07::checkout.index', $view->name());
    }

    function testStore()
    {
        $data = [
            'amount' => 6000,
            'premium_member' => 1,
            'shipping_express' => 2,
        ];
        $request = Mockery::mock(CheckoutRequest::class);
        $request->shouldReceive('all')->andReturn($data);
        $this->service->shouldReceive('calculateShippingFee')->andReturn($data);
        $controller = new CheckoutController($this->service);

        $response = $controller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals($data , $response->getSession()->all()['order']);
    }
}