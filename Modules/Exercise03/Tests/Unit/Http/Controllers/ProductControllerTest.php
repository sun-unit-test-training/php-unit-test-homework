<?php

namespace Modules\Exercise03\Tests\Unit\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;
use Tests\SetupDatabaseTrait;

class ProductControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $productController;
    protected $productService;

    protected function setUp(): void
    {
        parent::setup();

        $this->productService = $this->mock(ProductService::class);
        $this->productController = new ProductController($this->productService);
    }

    public function test__construct()
    {
        $controller = new ProductController($this->productService);

        $this->assertInstanceOf(ProductController::class, $controller);

    }

    public function test_index_return_view()
    {
        $this->productService
            ->shouldReceive('getAllProducts')
            ->once()
            ->andReturn([]);

        $view = $this->productController->index();

        $this->assertEquals('exercise03::index', $view->name());
    }

    public function test_checkout_return_json_response()
    {
        $this->productService
            ->shouldReceive('calculateDiscount')
            ->once()
            ->andReturn(100);

        $request = $this->mock(CheckoutRequest::class);
        $request->shouldReceive('input')->andReturn(100);

        $response = $this->productController->checkout($request);

        $this->assertEquals(100, $response->getData()->discount);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
