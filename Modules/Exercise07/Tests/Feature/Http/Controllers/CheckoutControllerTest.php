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
    protected $checkoutServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->checkoutServiceMock = $this->mock(CheckoutService::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test__contruct()
    {
        $controller = new CheckoutController($this->checkoutServiceMock);

        $this->assertInstanceOf(CheckoutController::class, $controller);
    }

    public function test_index()
    {
        $url = action([CheckoutController::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise07::checkout.index');
    }

    public function test_store()
    {
        $input = [
            'amount' => 99,
        ];

        $request = $this->mock(CheckoutRequest::class);
        $request->shouldReceive('all')
            ->once()
            ->andReturn($input);

        $this->checkoutServiceMock->shouldReceive('calculateShippingFee')
            ->with($input)
            ->once()
            ->andReturn();

        $controller = new CheckoutController($this->checkoutServiceMock);

        $this->assertInstanceOf(RedirectResponse::class, $controller->store($request));
    }
}
