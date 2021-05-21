<?php

namespace Tests\Feature\Http\Controllers;

use Modules\Exercise05\Http\Controllers\Exercise05Controller;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class Exercise05ControllerTest extends TestCase
{
    protected $orderService;
    protected $exercise05Controller;

    protected function setUp(): void
    {
        parent::setup();

        $this->orderService = $this->mock(OrderService::class);
        $this->exercise05Controller = new Exercise05Controller(
            $this->orderService
        );
    }

    public function test_index_return_view_success()
    {
        $optionReceives = config('exercise05.option_receive');
        $optionCoupons = config('exercise05.option_coupon');
        $response = $this->exercise05Controller->index();

        $this->assertEquals('exercise05::index', $response->getName());
        $this->assertEquals(compact('optionCoupons', 'optionReceives'), $response->getData());
    }

    public function test_function_store()
    {
        $input = [
            'price' => 200,
            'option_receive' => 1,
            'option_coupon' => 1
        ];
        $detailOrder = $input;
        $mockRequest = $this->mock(OrderRequest::class);
        $mockRequest->shouldReceive('only')->andReturn($input);

        $resultOrder = [
            'price' => 100,
            'discount_pizza' => 1,
            'discount_potato' => 1,
        ];

        $this->orderService->shouldReceive('handleDiscount')->andReturn($resultOrder);
        $response = $this->exercise05Controller->store($mockRequest);
        $this->assertEquals(compact('resultOrder', 'detailOrder'), $response->getData());
    }
}