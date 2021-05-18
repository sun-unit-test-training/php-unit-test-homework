<?php

namespace Tests\Unit\Services;

use InvalidArgumentException;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    protected $productRepositoryMock;
    protected $productService;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel helper: mock and bind to service container
        $this->productRepositoryMock = $this->mock(ProductRepository::class);
        $this->productService = new ProductService($this->productRepositoryMock);

    }

    public function test__construct()
    {
        $this->assertInstanceOf(ProductService::class, $this->productService);
    }

    public function test_get_all_products()
    {
        $this->productRepositoryMock
            ->shouldReceive('all')
            ->andReturn([]);
        $products = $this->productService->getAllProducts();

        $this->assertEquals($products, []);
    }

    /**
     * @param $totalProducts
     * @param $expectedValue
     * @dataProvider provideValidTotalProductsData
     * */
    public function test_calculate_discount_with_valid_data($totalProducts, $expectedValue)
    {
        $discount = $this->productService->calculateDiscount($totalProducts);
        $this->assertEquals($expectedValue, $discount);
    }

    public function provideValidTotalProductsData()
    {
        return [
            [
                [
                    1 => 2,
                    2 => 2,
                    3 => 2,
                ], 5
            ],
            [
                [
                    1 => 0,
                    2 => 4,
                    3 => 4,
                ], 7
            ],
            [
                [
                    1 => 2,
                    2 => 3,
                    3 => 3,
                ], 12
            ],
        ];
    }

    /**
     * @param $totalProducts
     * @dataProvider provideInvalidTotalProductsData
     * */
    public function test_exception_calculate_discount($totalProducts)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount($totalProducts);
    }

    public function provideInvalidTotalProductsData()
    {
        return [
            [
                [
                    1 => -1,
                    2 => 2,
                    3 => 2,
                ],
            ],
        ];
    }
}
