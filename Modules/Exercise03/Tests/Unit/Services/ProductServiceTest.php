<?php

namespace Tests\Unit\Services;

use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;
use InvalidArgumentException;

class ProductServiceTest extends TestCase
{
    protected $productService;
    protected $productRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepository = $this->mock(ProductRepository::class);
        $this->productService = new ProductService(
            $this->productRepository
        );
    }

    public function test_function_get_all_products()
    {
        $expected = ['products' => ['items']];
        $this->productRepository->shouldReceive('all')->andReturn($expected);

        $this->assertEquals($expected, $this->productService->getAllProducts());
    }

    public function test_calculate_discount_return_throw_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => -1,
            Product::WHITE_SHIRT_TYPE => -1,
            Product::OTHER_TYPE => -1,
        ]);
    }

    public function test_calculate_discount_return_white_shirt_discount()
    {
        $expected = ProductService::CRAVAT_WHITE_SHIRT_DISCOUNT;
        $result = $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => 2,
            Product::WHITE_SHIRT_TYPE => 1,
            Product::OTHER_TYPE => 0,
        ]);

        $this->assertEquals($expected, $result);
    }

    public function test_calculate_discount_return_discount_with_quantity_discount()
    {
        $expected = ProductService::QUANTITY_DISCOUNT + ProductService::CRAVAT_WHITE_SHIRT_DISCOUNT;
        $result = $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => 2,
            Product::WHITE_SHIRT_TYPE => 2,
            Product::OTHER_TYPE => 5,
        ]);

        $this->assertEquals($expected, $result);
    }
}
