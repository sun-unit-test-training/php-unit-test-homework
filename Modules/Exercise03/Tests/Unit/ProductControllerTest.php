<?php

namespace Modules\Exercise03\Tests\Unit;

use Tests\TestCase;
use Modules\Exercise03\Http\Controllers\ProductController;
use Mockery as m;
use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class ProductControllerTest extends TestCase
{
    protected $controller;
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = m::mock(ProductService::class);
        $this->controller = new ProductController($this->service);
    }

    public function test_index()
    {
        $this->service->shouldReceive('getAllProducts')->andReturn([]);

        $result = $this->controller->index();
        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('exercise03::index', $result->getName());
    }

    public function test_checkout()
    {
        $request =  $this->mock(CheckoutRequest::class)->makePartial();

        $request->shouldReceive('input')->andReturn([
            'total_products' => 1,
        ]);
        $this->service->shouldReceive('calculateDiscount')->andReturn([]);

        $result = $this->controller->checkout($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }
}
