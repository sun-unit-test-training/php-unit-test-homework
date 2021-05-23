<?php

namespace Modules\Exercise03\Tests\Unit\Services;

use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;
use InvalidArgumentException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductServiceTest extends TestCase
{
    protected $service;
    protected $productRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->productRepositoryMock = $this->mock(ProductRepository::class);
        $this->service = new ProductService($this->productRepositoryMock);
    }

    /**
     * @param $totalProducts
     * @param $expectedValue
     * @dataProvider provide_valid_products_data
     */
    public function test_calculateDiscount_valid_data($totalProducts, $expectedValue)
    {
        $discount = $this->service->calculateDiscount($totalProducts);
        $this->assertEquals($expectedValue, $discount);
    }

    public function provide_valid_products_data()
    {
        return [
            [
                [
                    Product::CRAVAT_TYPE => 1,
                    Product::WHITE_SHIRT_TYPE => 1,
                ],
                ProductService::CRAVAT_WHITE_SHIRT_DISCOUNT,
            ],
            [
                [
                    Product::CRAVAT_TYPE => 2,
                    Product::WHITE_SHIRT_TYPE => 3,
                    Product::OTHER_TYPE => 3
                ],
                12,
            ],
        ];
    }

    /**
     * @param $totalProducts
     * @dataProvider provide_invalid_products_data
     * */
    public function test_discount_throw_exception($totalProducts)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->calculateDiscount($totalProducts);
    }

    public function provide_invalid_products_data()
    {
        return [
            [
                [
                    1 => -1,
                    2 => 2,
                    3 => 3,
                ]
            ],
            [
                [
                    1 => 1,
                    2 => -2,
                    3 => 3,
                ]
            ],
            [
                [
                    1 => 1,
                    2 => 2,
                    3 => -3,
                ]
            ],
            [
                [
                    1 => -1,
                    2 => -2,
                    3 => -3,
                ]
            ]
        ];
    }

    public function test_get_all_products()
    {
        $this->productRepositoryMock->shouldReceive('all')
            ->andReturn([]);
        $products = $this->service->getAllProducts();

        $this->assertEquals($products, []);
    }
}
