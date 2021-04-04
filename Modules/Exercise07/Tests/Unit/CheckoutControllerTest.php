<?php

namespace Modules\Exercise07\Tests\Unit;

use Mockery;
use Tests\TestCase;
use Illuminate\Http\RedirectResponse;
use Modules\Exercise07\Services\CheckoutService;
use Modules\Exercise07\Http\Requests\CheckoutRequest;
use Modules\Exercise07\Http\Controllers\CheckoutController;

/**
 * Class CheckoutControllerTest
 */
class CheckoutControllerTest extends TestCase
{
    /**
     * Store a new resource success
     *
     * @test
     *
     * @return void
     */
    public function store_new_resource_success()
    {
        $request = new CheckoutRequest();
        $mockService = Mockery::mock(CheckoutService::class)->makePartial();
        $checkoutController = new CheckoutController($mockService);

        $mockService->shouldReceive('calculateShippingFee')
            ->with($request->all())
            ->once()
            ->andReturn(200);

        $response = $checkoutController->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
