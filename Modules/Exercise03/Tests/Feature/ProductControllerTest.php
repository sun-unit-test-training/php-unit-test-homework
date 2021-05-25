<?php

namespace Modules\Exercise03\Tests\Feature;

use Mockery;
use Tests\TestCase;
use Tests\SetupDatabaseTrait;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Http\Controllers\ProductController;

class ProductControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $productService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productService = $this->mock(ProductService::class);
    }

    function testGetAllProducts()
    {
        $product = Product::newFactory();
        $this->productService->shouldReceive('getAllProducts')->andReturn($product);
        $controller = new ProductController($this->productService);

        $view = $controller->index();

        $this->assertEquals('exercise03::index', $view->getName());
    }

    function testCheckout()
    {
        $request = Mockery::mock(CheckoutRequest::class);
        $request->shouldReceive('input')->andReturn([
            'total_products' => [
                Product::CRAVAT_TYPE => 1,
                Product::WHITE_SHIRT_TYPE => 1,
                Product::OTHER_TYPE => 1,
            ],
        ]);
        $discount = ProductService::CRAVAT_WHITE_SHIRT_DISCOUNT;
        $this->productService->shouldReceive('calculateDiscount')->andReturn($discount);
        $controller = new ProductController($this->productService);

        $response = $controller->checkout($request);

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($response->getData()->discount, $discount);
    }
}