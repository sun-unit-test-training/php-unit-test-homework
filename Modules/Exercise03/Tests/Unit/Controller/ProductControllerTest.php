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
    protected $productServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->productServiceMock = $this->mock(ProductService::class);
    }

    public function test_index_returns_view()
    {
        $this->productServiceMock->shouldReceive('getAllProducts')
            ->once()
            ->andReturn([]);

        $url = action([ProductController::class, 'index']);
        $response = $this->get($url);

        $response->assertViewIs('exercise03::index');
        $response->assertViewHas('products');
    }

    public function test_checkout_when_input_valid()
    {
        $productService = $this->mock(ProductService::class, function (MockInterface $mock) {
            $mock->shouldReceive('calculateDiscount')
                ->once()
                ->andReturn(100);
        });

        $controller = new ProductController($productService);
        $request = new CheckoutRequest([
            'total_products' => []
        ]);

        $response = $controller->checkout($request);

        $this->assertEquals(100, $response->getData()->discount);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    public function test_checkout_when_input_invalid()
    {
        $url = action([ProductController::class, 'checkout']);

        $response = $this->post($url, [
            'totals_product' => 'Input Invalid',
        ]);

        $response->assertStatus(302);
    }
}
