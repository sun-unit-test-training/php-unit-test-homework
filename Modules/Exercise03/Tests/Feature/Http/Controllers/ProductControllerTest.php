<?php

namespace Modules\Exercise03\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Http\Controllers\ProductController;

class ProductControllerTest extends TestCase
{
    /**
     * @var ProductController
     */
    protected $productController;

    /**
     * @var \Mockery\MockInterface
     */
    protected $productService;

    protected function setUp(): void
    {
        parent::setup();

        $this->productService = \Mockery::mock(ProductService::class);
        $this->productController = new ProductController(
            $this->productService
        );
    }

    public function test_checkout_returns_json_response()
    {
        $mockedRequest = \Mockery::mock(CheckoutRequest::class);
        $mockedRequest->shouldReceive('input')->andReturn([]);
        $discount = 1;
        $this->productService->shouldReceive('calculateDiscount')->andReturn($discount);
        $response = $this->productController->checkout($mockedRequest);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['discount' => $discount], $response->getOriginalContent());
    }

    public function test_index_returns_view()
    {
        $products = ['foo' => 'bar'];
        $this->productService->shouldReceive('getAllProducts')->andReturn($products);
        $response = $this->productController->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('exercise03::index', $response->getName());
        $this->assertEquals(compact('products'), $response->getData());
    }
}
