<?php

namespace Tests\Feature;

use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;
use Mockery;

class ProductControllerTest extends TestCase
{
    public function test__construct()
    {
        $service = Mockery::mock(ProductService::class);
        $controller = new ProductController($service);
        $repositoryRef = $this->getHiddenProperty($controller, 'productService');
        $this->assertSame($service, $repositoryRef->getValue($controller));
    }

    public function test_index_success_with_products()
    {
        $product = Product::newFactory();
        $cravat = $product->cravat()->create();
        $whiteShirt = $product->whiteShirt()->create();
        $other = $product->other()->create();

        $response = $this->get(route('exercise03.index'));
        $productResponse = $response->viewData('products');

        $response->assertStatus(200);
        $response->assertViewIs('exercise03::index');
        $this->assertEquals($productResponse[0]['name'], $cravat->name);
        $this->assertEquals($productResponse[1]['name'], $whiteShirt->name);
        $this->assertEquals($productResponse[2]['name'], $other->name);
    }

    public function test_index_success_without_product()
    {
        $response = $this->get(route('exercise03.index'));
        $productResponse = $response->viewData('products');

        $response->assertStatus(200);
        $response->assertViewIs('exercise03::index');
        $this->assertEmpty($productResponse);
    }

    public function test_checkout_with_cravat_error()
    {
        $response = $this->postJson(route('exercise03.checkout'), [
            'total_products' => [
                1 => -1,
                2 => 3,
                3 => 3,
            ],
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('errors', ["total_products.1" => ["The total_products.1 must be at least 0."]])
            ->assertJsonPath('message', 'The given data was invalid.');
    }

    public function test_checkout_with_white_shirt_error()
    {
        $response = $this->postJson(route('exercise03.checkout'), [
            'total_products' => [
                1 => 2,
                2 => -3,
                3 => 3,
            ],
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('errors', ["total_products.2" => ["The total_products.2 must be at least 0."]])
            ->assertJsonPath('message', 'The given data was invalid.');
    }

    public function test_checkout_with_other_product_error()
    {
        $response = $this->postJson(route('exercise03.checkout'), [
            'total_products' => [
                1 => 2,
                2 => 3,
                3 => -3,
            ],
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('errors', ["total_products.3" => ["The total_products.3 must be at least 0."]])
            ->assertJsonPath('message', 'The given data was invalid.');
    }

    public function test_checkout_success_all_products()
    {
        $response = $this->json('POST', route('exercise03.checkout'), [
            'total_products' => [
                1 => 3,
                2 => 2,
                3 => 2,
            ],
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('discount', 12);
    }

    public function test_checkout_success_all_products_more()
    {
        $response = $this->json('POST', route('exercise03.checkout'), [
            'total_products' => [
                1 => 3,
                2 => 2,
                3 => 8,
            ],
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('discount', 12);
    }

    public function test_checkout_success_with_only_cravat_white_shirt()
    {
        $response = $this->json('POST', route('exercise03.checkout'), [
            'total_products' => [
                1 => 2,
                2 => 3,
                3 => 1,
            ],
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('discount', 5);
    }
}
