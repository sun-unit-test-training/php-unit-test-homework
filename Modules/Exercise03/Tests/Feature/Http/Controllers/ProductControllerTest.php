<?php

namespace Modules\Exercise03\Tests\Feature\Http\Controllers;

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
        $discount = 10;
        $paramRequest = [
            1 => 5,
            2 => 6,
        ];
        $this->productService->shouldReceive('calculateDiscount')->with($paramRequest)->andReturn($discount);

        $url = action([ProductController::class, 'checkout']);
        $response = $this->post($url, ['total_products' => $paramRequest]);
        $response->assertOk();
        $response->assertJsonPath('discount', $discount);
    }
}
