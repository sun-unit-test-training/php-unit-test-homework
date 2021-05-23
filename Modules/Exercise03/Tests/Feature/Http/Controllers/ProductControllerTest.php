<?php

namespace Modules\Tests\Exercise03\Tests\Http\Controllers;

use Illuminate\View\View;
use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    private $productService;
    private $productController;

    public function setUp(): void
    {
        parent::setUp();

        $this->productService = \Mockery::mock(ProductService::class);
        $this->productController = new ProductController(
            $this->productService
        );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $products = [
            'name' => 'name',
            'status' => 1
        ];

        $this->productService->shouldReceive('getAllProducts')
            ->andReturn($products);
        $response = $this->productController->index();
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('exercise03::index', $response->getName());
    }

    public function testCheckout() {
        $input['total_products'] = [
            1 => 1,
            2 => 2,
            3 => 3
        ];

        $this->productService->shouldReceive('calculateDiscount')
            ->with($input)
            ->andReturn(5);
        $mockRequest = \Mockery::mock(CheckoutRequest::class);
        $mockRequest->shouldReceive('input')->andReturn($input);
        $response = $this->productController->checkout($mockRequest);
        $this->assertEquals(['discount' => 5], $response->getOriginalContent());
    }
}
