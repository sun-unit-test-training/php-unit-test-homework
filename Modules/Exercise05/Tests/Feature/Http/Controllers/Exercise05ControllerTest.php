<?php

namespace Modules\Tests\Exercise05\Tests\Http\Controllers;

use Illuminate\View\View;
use Modules\Exercise05\Http\Controllers\Exercise05Controller;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class Exercise05ControllerTest extends TestCase
{
    private $controller;
    private $mockOrderService;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockOrderService = $this->mock(OrderService::class);
        $this->controller = new Exercise05Controller($this->mockOrderService);
    }

    public function testIndex()
    {
        $response = $this->controller->index();
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('exercise05::index', $response->getName());
    }

    public function testStore()
    {
        $detailOrder = [
            'price' => 100,
            'option_receive' => 1,
            'option_coupon' => 1
        ];

        $mockRequest = $this->mock(OrderRequest::class);
        $mockRequest->shouldReceive('only')
            ->andReturn($detailOrder);

        $this->mockOrderService
            ->shouldReceive('handleDiscount')
            ->andReturn(1);

        $res = $this->controller->store($mockRequest);
        $this->assertEquals('exercise05::detail', $res->getName());
    }
}
