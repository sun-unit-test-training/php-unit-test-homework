<?php

namespace Tests\Unit\Services;

use InvalidArgumentException;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    protected $productRepository;
    protected $productService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepository = $this->mock(ProductRepository::class);
        $this->productService = new ProductService($this->productRepository);

    }

    public function test__construct()
    {
        $this->assertInstanceOf(ProductService::class, $this->productService);
    }

    public function test_get_all_products()
    {
        $this->productRepository
            ->shouldReceive('all')
            ->andReturn([]);
        $products = $this->productService->getAllProducts();

        $this->assertEquals($products, []);
    }

    /**
     * @dataProvider provide_input_calculate_discount_success
     * */
    public function test_calculate_discount_success($totalProducts, $expectedValue)
    {
        $discount = $this->productService->calculateDiscount($totalProducts);
        $this->assertEquals($expectedValue, $discount);
    }

    public function provide_input_calculate_discount_success()
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

    public function test_calculate_discount_throw_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => -1,
            Product::WHITE_SHIRT_TYPE => -2,
            Product::OTHER_TYPE => -3,]);
    }
}