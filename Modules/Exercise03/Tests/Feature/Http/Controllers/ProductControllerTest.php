<?php

namespace Tests\Feature;

use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    protected $controller;
    protected $productService;

    protected function setUp(): void
    {
        parent::setup();

        $this->productService = $this->mock(ProductService::class);
        $this->controller = new ProductController($this->productService);
    }

    public function test_index_return_view_success()
    {
        $products = ['name' => 'name'];
        $this->productService->shouldReceive('getAllProducts')
            ->andReturn($products);
        $response = $this->controller->index();

        $this->assertEquals('exercise03::index', $response->getName());
        $this->assertEquals(compact('products'), $response->getData());
    }

    public function test_checkout_return_view_success()
    {
        $inputs = [
            'total_products' => 1,
        ];

        $request = CheckoutRequest::create('', 'post', $inputs);
        $this->productService->shouldReceive('calculateDiscount')
            ->with($inputs['total_products'])
            ->andReturn(1);
        $response = $this->controller->checkout($request);

        $this->assertEquals(['discount' => 1], $response->getOriginalContent());
        $this->assertEquals(200, $response->status());
    }
}
