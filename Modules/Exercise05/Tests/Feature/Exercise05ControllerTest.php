<?php

namespace Modules\Exercise05\Tests\Feature;

use Mockery;
use Tests\TestCase;
use Tests\SetupDatabaseTrait;
use Modules\Exercise05\Services\OrderService;
use Modules\Exercise05\Http\Controllers\Exercise05Controller;
use Modules\Exercise05\Http\Requests\OrderRequest;

class Exercise05ControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->mock(OrderService::class);
    }

    function testIndex()
    {
        $controller = new Exercise05Controller($this->service);

        $view = $controller->index();

        $this->assertEquals('exercise05::index', $view->name());
        $this->assertArrayHasKey('optionReceives', $view->getData());
        $this->assertArrayHasKey('optionCoupons', $view->getData());
        $this->assertEquals($view->getData()['optionReceives'], config('exercise05.option_receive'));
        $this->assertEquals($view->getData()['optionCoupons'], config('exercise05.option_coupon'));
    }

    function testStore()
    {
        $data = [
            'price' => 100,
            'option_receive' => 1,
            'option_coupon' => 1,
        ];
        $request = Mockery::mock(OrderRequest::class);
        $request->shouldReceive('only')->andReturn($data);
        $this->service->shouldReceive('handleDiscount')->andReturn($data);
        $controller = new Exercise05Controller($this->service);

        $view = $controller->store($request);

        $this->assertEquals('exercise05::detail', $view->name());
        $this->assertArrayHasKey('resultOrder', $view->getData());
        $this->assertArrayHasKey('detailOrder', $view->getData());
    }
}