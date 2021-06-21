<?php

namespace Modules\Exercise05\Tests\Feature\Http\Controllers;

use Modules\Exercise05\Http\Controllers\Exercise05Controller;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class Exercise05ControllerTest extends TestCase
{
    protected $orderService;
    protected $exerciseController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderService = $this->mock(OrderService::class);
        $this->exerciseController = new Exercise05Controller($this->orderService);
    }

    public function test_index()
    {
        $optionReceives = config('exercise05.option_receive');
        $optionCoupons = config('exercise05.option_coupon');
        $response = $this->exerciseController->index();

        $this->assertEquals('exercise05::index', $response->getName());
        $this->assertArrayHasKey('optionReceives', $response->getData());
        $this->assertArrayHasKey('optionCoupons', $response->getData());
        $this->assertEquals(compact('optionCoupons', 'optionReceives'), $response->getData());
    }

    public function test_store_success()
    {
        $expectedResultOrder = 1;
        $formRequest = [];
        $mockRequest = $this->mock(OrderRequest::class);
        $mockRequest->shouldReceive('only')->andReturn($formRequest);
        $this->orderService
            ->shouldReceive('handleDiscount')
            ->with($formRequest)
            ->andReturn($expectedResultOrder);

        $response = $this->exerciseController->store($mockRequest);

        $this->assertEquals('exercise05::detail', $response->getName());
        $this->assertEquals($expectedResultOrder, $response->getData()['resultOrder']);
        $this->assertEquals($formRequest, $response->getData()['detailOrder']);
    }
}
