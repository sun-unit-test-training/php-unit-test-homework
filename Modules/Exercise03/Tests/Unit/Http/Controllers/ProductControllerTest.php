<?php

namespace Tests\Unit;

use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Models\Product;
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
        $products = Product::factory()->count(3)->make();
        $this->productService->shouldReceive('getAllProducts')
            ->andReturn($products);
        $response = $this->controller->index();

        $this->assertEquals('exercise03::index', $response->getName());
        $this->assertEquals(compact('products'), $response->getData());
        $this->assertCount(3, $response->getData()['products']);
    }

    public function test_checkout_return_view_success()
    {
        $inputs = [
            'total_products' => [
                Product::CRAVAT_TYPE => 5,
                Product::WHITE_SHIRT_TYPE => 2,
                Product::OTHER_TYPE => 1
            ],
        ];
        $request = CheckoutRequest::create('', 'post', $inputs);
        $this->productService->shouldReceive('calculateDiscount')
            ->with($inputs['total_products'])
            ->andReturn(12);
        $response = $this->controller->checkout($request);
        $this->assertObjectHasAttribute('discount', $response->getData());
        $this->assertEquals(200, $response->status());
    }
}
