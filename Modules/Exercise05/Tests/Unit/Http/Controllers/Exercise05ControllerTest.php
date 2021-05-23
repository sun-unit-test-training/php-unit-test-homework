<?php

namespace Tests\Unit\Http\Controllers;

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
        $this->exercise05Controller = new Exercise05Controller($this->orderService);
    }

    public function test__construct()
    {
        $controller = new Exercise05Controller($this->orderService);

        $this->assertInstanceOf(Exercise05Controller::class, $controller);

    }

    public function test_index_return_view()
    {
        $optionReceives = config('exercise05.option_receive');
        $optionCoupons = config('exercise05.option_coupon');
        $view = $this->exercise05Controller->index();

        $this->assertEquals('exercise05::index', $view->name());
        $this->assertEquals(compact('optionCoupons', 'optionReceives'), $view->getData());
    }

    public function test_store()
    {
        $frmInput = [
            'price' => 10,
            'option_receive' => 1,
            'option_coupon' => 2
        ];
        $resultOrder = 1;
        $detailOrder = $frmInput;
        $requestMock = $this->mock(OrderRequest::class);
        $requestMock->shouldReceive('only')->andReturn($frmInput);
        $this->orderService->shouldReceive('handleDiscount')->andReturn(1);
        $response = $this->exercise05Controller->store($requestMock);

        $this->assertEquals(compact('resultOrder', 'detailOrder'), $response->getData());
    }
}
