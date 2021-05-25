<?php

namespace Tests\Feature;

use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    protected $productController;
    protected $productService;

    protected function setUp(): void
    {
        parent::setup();

        $this->productService = $this->mock(ProductService::class);
        $this->productController = new ProductController($this->productService);
    }

    public function test_index_return_view_success()
    {
        $products = ['name' => 'test_product'];
        $this->productService->shouldReceive('getAllProducts')->andReturn($products);
        $response = $this->productController->index();
        $this->assertEquals('exercise03::index', $response->getName());
        $this->assertEquals(compact('products'), $response->getData());
    }

    public function test_checkout_return_view_success()
    {
        $mockRequest = $this->mock(CheckoutRequest::class);
        $mockRequest->shouldReceive('input')->andReturn([]);
        $this->productService->shouldReceive('calculateDiscount')->andReturn(1);
        $response = $this->productController->checkout($mockRequest);
        $this->assertEquals(['discount' => 1], $response->getOriginalContent());
    }
}
