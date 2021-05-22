<?php

namespace Tests\Feature\Http\Controllers;

use Modules\Exercise05\Http\Controllers\Exercise05Controller;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class Exercise05ControllerTest extends TestCase
{
    protected $controller;
    protected $orderService;

    protected function setUp(): void
    {
        parent::setup();

        $this->orderService = $this->mock(OrderService::class);
        $this->controller = new Exercise05Controller($this->orderService);
    }

    public function test_index_return_view_success()
    {
        $response = $this->controller->index();

        $this->assertEquals('exercise05::index', $response->getName());
        $this->assertArrayHasKey('optionCoupons', $response->getData());
        $this->assertArrayHasKey('optionReceives', $response->getData());
    }

    public function test_store_success()
    {
        $inputs = [
            'price' => 1,
            'option_receive' => 1,
            'option_coupon' => 1
        ];

        $request = OrderRequest::create('', 'post', $inputs);
        $this->orderService->shouldReceive('handleDiscount')
            ->with($inputs)
            ->andReturn(1);
        $response = $this->controller->store($request);
        $data = $response->getData();

        $this->assertEquals('exercise05::detail', $response->getName());
        $this->assertEquals(1, $data['resultOrder']);
        $this->assertEquals($inputs, $data['detailOrder']);
    }
}
