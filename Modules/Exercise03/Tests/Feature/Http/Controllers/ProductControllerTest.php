<?php

namespace Modules\Exercise03\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Services\ProductService;
use Tests\SetupDatabaseTrait;

class ProductControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $productServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
    }

    function test_it_index()
    {

        $productService = $this->mock(ProductService::class);
        $productService
            ->shouldReceive('getAllProducts')
            ->andReturn([]);

        $url = action([ProductController::class, 'index']);
        $response = $this->get($url);

        $response->assertViewIs('exercise03::index');
        $response->assertViewHas('products');
    }

    /**
     * @dataProvider provideWrongTotalProducts
     * @dataProvider provideWrongTotalCravat
     * @dataProvider provideWrongTotalWhiteShirt
     * @dataProvider provideWrongTotalOther
     */
    function test_it_show_error_when_input_invalid($key, $value)
    {
        $url = action([ProductController::class, 'checkout']);

        $response = $this->post($url, ['total_products' => $value]);

        $response->assertSessionHasErrors([$key]);
    }

    function provideWrongTotalProducts()
    {
        return [
            ['total_products', null],
            ['total_products', 1]
        ];
    }

    function provideWrongTotalCravat()
    {
        return [
            ['total_products.1', [1 => 1.1, 2 => 2, 3 => 3]],
            ['total_products.1', [1 => -1, 2 => 2, 3 => 3]],
        ];
    }

    function provideWrongTotalWhiteShirt()
    {
        return [
            ['total_products.2', [1 => 1, 2 => 2.2, 3 => 3]],
            ['total_products.2', [1 => 1, 2 => -1, 3 => 3]],
        ];
    }

    function provideWrongTotalOther()
    {
        return [
            ['total_products.3', [1 => 1, 2 => 2, 3 => 3.3]],
            ['total_products.3', [1 => 1, 2 => 2, 3 => -1]],
        ];
    }

    /**
     * @dataProvider provideValidTotalProducts
     */
    function test_it_checkout_when_input_valid($discount, $totalProducts)
    {
        $url = action([ProductController::class, 'checkout']);

        $response = $this->post($url, ['total_products' => $totalProducts]);

        $response->assertStatus(200)
            ->assertJson([
                'discount' => $discount
            ]);
    }

    function provideValidTotalProducts()
    {
        return [
            'Have Cravat White Shirt & Total Less Than 7' => [5, [1 => 1, 2 => 1, 3 => 1]],
            'Have Cravat White Shirt & Total Equal 7' => [12, [1 => 1, 2 => 1, 3 => 5]],
            'No Have Both Cravat White Shirt & Total Equal 7' => [7, [1 => 1, 2 => 0, 3 => 6]],
            'No Have Both Cravat White Shirt & Total Less Than 7' => [0, [1 => 1, 2 => 0, 3 => 3]],
        ];
    }
}
