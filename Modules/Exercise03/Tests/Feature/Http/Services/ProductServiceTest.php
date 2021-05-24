<?php

namespace Modules\Exercise03\Tests\Feature\Http\Services;

use InvalidArgumentException;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    protected $productRepository;
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepository = $this->mock(ProductRepository::class);
        $this->service = new ProductService($this->productRepository);

    }

    public function test_get_all_products()
    {
        $this->productRepository->shouldReceive('all')
            ->andReturn([]);
        $products = $this->service->getAllProducts();

        $this->assertEquals($products, []);
    }

    /**
     * @param $totalProducts
     * @param $expectedValue
     * @dataProvider provide_total_products_data
     * */
    public function test_calculate_discount_with_valid_data($totalProducts, $expectedValue)
    {
        $discount = $this->service->calculateDiscount($totalProducts);
        $this->assertEquals($expectedValue, $discount);
    }

    public function provide_total_products_data()
    {
        return [
            [
                [
                    Product::CRAVAT_TYPE => 1,
                    Product::WHITE_SHIRT_TYPE => 2,
                    Product::OTHER_TYPE => 0,
                ], ProductService::CRAVAT_WHITE_SHIRT_DISCOUNT
            ],
            [
                [
                    Product::CRAVAT_TYPE => 2,
                    Product::WHITE_SHIRT_TYPE => 3,
                    Product::OTHER_TYPE => 5,
                ], 12
            ],
        ];
    }

    public function test_calculate_discount_throw_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->calculateDiscount([
            Product::CRAVAT_TYPE => -1,
            Product::WHITE_SHIRT_TYPE => -2,
            Product::OTHER_TYPE => -3,
        ]);
    }
}
