<?php

namespace Modules\Exercise03\Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise03\Http\Controllers\ProductController as Exercise;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Services\ProductService;
use Tests\SetupDatabaseTrait;

class ProductControllerTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $serviceMock;
    protected $controllerMethod;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->serviceMock = $this->mock(ProductService::class);
        $this->controllerMethod = 'checkout';
    }

    function test_checkout_success()
    {
        $dummyDisscount = ProductService::CRAVAT_WHITE_SHIRT_DISCOUNT;

        $dumyProductData = [
            Product::CRAVAT_TYPE => 'Product1',
            Product::WHITE_SHIRT_TYPE => 'Product2',
            Product::OTHER_TYPE => 'Product3',
        ];

        foreach ($dumyProductData as $type => $name) {
            Product::factory()->create([
                'name' => $name,
                'type' => $type,
            ]);
        }

        $this->serviceMock
            ->shouldReceive('calculateDiscount')
            ->andReturn($dummyDisscount);

        $url = action([Exercise::class, $this->controllerMethod]);

        $response = $this->post($url, ['total_products' => array_keys($dumyProductData)]);

        $response->assertSessionDoesntHaveErrors(['total_products']);
        $response->assertOk();
        $response->assertJsonPath('discount', $dummyDisscount);
    }

    function test_index()
    {
        $url = action([Exercise::class, 'index']);

        $this->serviceMock
            ->shouldReceive('getAllProducts')
            ->andReturn(collect([]));

        $response = $this->get($url);

        $response->assertViewIs('exercise03::index');
        $response->assertViewHasAll([
            'products',
        ]);
    }

    /**
     * @dataProvider provideWrongProduct
     */
    function test_it_show_error_when_input_invalid($inputKey, $inputValue)
    {
        $url = action([Exercise::class, $this->controllerMethod]);
        $inputs = [$inputKey => $inputValue];

        $response = $this->post($url, $inputs);

        $response->assertSessionHasErrors([$inputKey]);
    }

    function provideWrongProduct()
    {
        return [
            'Product is missing' => [null, null],
            'Product is required' => ['total_products', null],
            'Product is not array' => ['total_products', 'not_array'],
        ];
    }

    /**
     * @dataProvider provideWrongProductType
     */
    function test_it_redirect_back_when_input_product_type_invalid($inputKey, $inputValue)
    {
        $url = action([Exercise::class, $this->controllerMethod]);
        $inputs = [$inputKey => $inputValue];

        $response = $this->post($url, $inputs);

        $response->assertRedirect('/');
    }

    function provideWrongProductType()
    {
        return [
            'Product type is not integer' => ['total_products.*', ['not_integer']],
            'Product type less than zero' => ['total_products.*', [0]],
        ];
    }
}
