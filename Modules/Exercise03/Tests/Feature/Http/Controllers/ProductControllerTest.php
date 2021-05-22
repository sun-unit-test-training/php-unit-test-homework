<?php

namespace Modules\Exercise03\Tests\Feature\Http\Controllers;

use Modules\Exercise03\Http\Controllers\ProductController;
use Tests\TestCase;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Services\ProductService;
use Tests\SetupDatabaseTrait;

class ProductControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $productServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productServiceMock = $this->mock(ProductService::class);
    }

    public function test_index_return_view()
    {
        $this->productServiceMock
            ->shouldReceive('getAllProducts')
            ->andReturn([]);

        $url = action([ProductController::class, 'index']);
        $response = $this->get($url);

        $response->assertViewIs('exercise03::index');
        $response->assertViewHas('products');
    }

    public function test_checkout_success()
    {
        $url = action([ProductController::class, 'checkout']);
        $paramRequest = [
            1 => 7,
            2 => 9,
        ];
        $this->productServiceMock->shouldReceive('calculateDiscount')->with($paramRequest)
            ->andReturn(12);

        $response = $this->post($url, ['total_products' => $paramRequest]);

        $this->assertEquals($response->status(), 200);
        $this->assertEquals($response->getData(true), ['discount' => 12]);
    }
}
