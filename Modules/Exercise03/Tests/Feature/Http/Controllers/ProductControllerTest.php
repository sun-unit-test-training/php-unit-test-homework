<?php

namespace Tests\Feature\Http\Controllers;

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

        // Laravel helper: mock and bind to service container
        $this->productServiceMock = $this->mock(ProductService::class);
    }

    function test_it_show_index()
    {
        $url = action([ProductController::class, 'index']);

        $product = new Product(['name' => 'producttest', 'type' => 1]);

        $this->productServiceMock->shouldReceive('getAllProducts')->andReturn([$product]);

        $response = $this->get($url);

        $response->assertViewIs('exercise03::index');
        $response->assertViewHas('products');
    }

    public function test_checkout_success()
    {
        $url = action([ProductController::class, 'checkout']);
        $totalProduct = [
            'total_products' => [
                1 => 5,
                2 => 5,
                3 => 5,
            ],
        ];
        $this->productServiceMock->shouldReceive('calculateDiscount')->with([
            1 => 5,
            2 => 5,
            3 => 5,
        ])
            ->andReturn(12);

        $response = $this->post($url, $totalProduct);


        $response->assertStatus(200)
            ->assertJsonPath(
                'discount',
                12,
            );
    }
}
