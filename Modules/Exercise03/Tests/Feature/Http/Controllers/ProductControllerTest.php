<?php

namespace Modules\Exercise03\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Services\ProductService;
use Tests\SetupDatabaseTrait;
use Modules\Exercise03\Http\Requests\CheckoutRequest;

class ProductControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $productServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productServiceMock = $this->mock(ProductService::class);
    }

    function test_it_index_return_view()
    {
        $this->productServiceMock
            ->shouldReceive('getAllProducts')
            ->andReturn([]);

        $url = action([ProductController::class, 'index']);
        $response = $this->get($url);

        $response->assertViewIs('exercise03::index');
        $response->assertViewHas('products');
    }

    function test_it_checkout_return_json_response()
    {
        $request = $this->mock(CheckoutRequest::class);
        $request->shouldReceive('input')->andReturn([1 => -1, 2 => 1, 3 => 3]);

        $this->productServiceMock
            ->shouldReceive('calculateDiscount')
            ->andReturn(12);

        $url = action([ProductController::class, 'checkout']);
        $response = $this->post($url);

        $this->assertEquals($response->status(), 200);
        $this->assertEquals($response->getData(true), ['discount' => 12]);
    }
}
