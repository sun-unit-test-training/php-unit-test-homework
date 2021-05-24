<?php

namespace Modules\Exercise03\Tests\Feature\Http\Controllers;


use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    protected $productController;
    protected $productService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productService = $this->mock(ProductService::class);
        $this->productController = new ProductController($this->productService);
    }

    function test_it_index()
    {
        $this->productService->shouldReceive('getAllProducts')->andReturn([]);
        $url = action([ProductController::class, 'index']);
        $response = $this->get($url);
        $response->assertViewIs('exercise03::index');
        $response->assertViewHas('products');
    }

    function test_it_checkout(){
        $input['total_products'] = [
            Product::CRAVAT_TYPE => 1,
            Product::WHITE_SHIRT_TYPE => 2,
            Product::OTHER_TYPE => 3
        ];

        $this->productService->shouldReceive('calculateDiscount')->with($input)->andReturn(5);
        $mockRequest = \Mockery::mock(CheckoutRequest::class);
        $mockRequest->shouldReceive('input')->andReturn($input);
        $response = $this->productController->checkout($mockRequest);
        $this->assertEquals(['discount' => 5], $response->getOriginalContent());
    }
}
