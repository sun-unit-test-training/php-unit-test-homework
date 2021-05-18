<?php

namespace Modules\Exercise03\Tests\Unit\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    protected $productServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->productServiceMock = $this->mock(ProductService::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test__contruct()
    {
        $controller = new ProductController($this->productServiceMock);

        $this->assertInstanceOf(ProductController::class, $controller);

    }

    public function test_index()
    {
        $this->productServiceMock->shouldReceive('getAllProducts')
            ->once()
            ->andReturn([]);
        $url = action([ProductController::class, 'index']);

        $response = $this->get($url);

        $response->assertViewIs('exercise03::index');
        $response->assertViewHas('products');
    }

    public function test_checkout()
    {
        $input = [
            1 => 2,
            2 => 3,
            3 => 3,
        ];

        $request = $this->mock(CheckoutRequest::class);
        $request->shouldReceive('input')
            ->once()
            ->with('total_products')
            ->andReturn($input);

        $this->productServiceMock->shouldReceive('calculateDiscount')
            ->with($input)
            ->once()
            ->andReturn(7);

        $controller = new ProductController($this->productServiceMock);

        $this->assertInstanceOf(JsonResponse::class, $controller->checkout($request));
    }
}
