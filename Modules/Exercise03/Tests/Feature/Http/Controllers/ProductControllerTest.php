<?php

namespace Modules\Exercise03\Tests\Unit\Controller;

use Illuminate\Http\JsonResponse;
use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;
use Mockery\MockInterface;

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

    public function test_index_return_view()
    {
        $products = ['name' => 'test'];
        $this->productService->shouldReceive('getAllProducts')->andReturn($products);

        $response = $this->productController->index();
        $this->assertEquals('exercise03::index', $response->getName());
        $this->assertEquals(compact('products'), $response->getData());
    }

    public function test_checkout()
    {
        $productService = $this->mock(ProductService::class, function (MockInterface $mock) {
            $mock->shouldReceive('calculateDiscount')
                ->once()
                ->andReturn(100);
        });

        $request = [
            'total_products' => []
        ];
        $request = new CheckoutRequest($request);

        $controller = new ProductController ($productService);
        $response = $controller->checkout($request);

        $this->assertEquals(100, $response->getData()->discount);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}