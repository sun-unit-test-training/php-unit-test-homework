<?php

namespace Modules\Exercise03\Tests\Unit\Services;

use InvalidArgumentException;
use Mockery\MockInterface;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    public function test_get_all_product_function()
    {
        $productRepository = $this->mock(ProductRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('all')
                ->once()
                ->andReturn([
                    'name' => 'Product Test'
                ]);
        });

        $productService = new ProductService($productRepository);
        $result = $productService->getAllProducts();

        $this->assertEquals([
            'name' => 'Product Test'
        ], $result);
    }

    public function test_caculate_discount_function_with_invalid_input()
    {
        $invalidInput = [
            Product::CRAVAT_TYPE => -1,
        ];
        $productRepository = $this->mock(ProductRepository::class);
        $productService = new ProductService($productRepository);

        $this->expectException(InvalidArgumentException::class);

        $productService->calculateDiscount($invalidInput);
    }

    /**
     * @dataProvider caculate_discount_data_provider
     */
    public function test_caculate_discount_function_with_valid_input($input, $expected)
    {
        $productRepository = $this->mock(ProductRepository::class);
        $productService = new ProductService($productRepository);

        $this->assertEquals($expected, $productService->calculateDiscount($input));
    }

    public function caculate_discount_data_provider()
    {
        return [
            [
                [],
                0
            ],
            [
                [
                    Product::CRAVAT_TYPE => 1,
                    Product::WHITE_SHIRT_TYPE => 1
                ],
                ProductService::CRAVAT_WHITE_SHIRT_DISCOUNT
            ],
            [
                [
                    Product::CRAVAT_TYPE => 1,
                    Product::WHITE_SHIRT_TYPE => 1,
                    Product::OTHER_TYPE => 100
                ],
                ProductService::QUANTITY_DISCOUNT + ProductService::CRAVAT_WHITE_SHIRT_DISCOUNT
            ],
        ];
    }
}
