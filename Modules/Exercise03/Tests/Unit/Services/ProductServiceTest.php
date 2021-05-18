<?php

namespace Modules\Exercise03\Tests\Unit\Services;

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

    public function test_get_all_products()
    {
        $dataAll = ['abc' => 'def'];
        $this->productRepository->shouldReceive('all')->andReturn($dataAll);

        $this->assertEquals($dataAll, $this->productService->getAllProducts());
    }

    public function test_calculate_discount_throw_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        // @TODO: check branch
        $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => -1,
        ]);
    }

    public function test_calculate_discount_white_shirt()
    {
        $discount = $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => 2,
            Product::WHITE_SHIRT_TYPE => 2,
            Product::OTHER_TYPE => 1,
        ]);

        $this->assertEquals(ProductService::CRAVAT_WHITE_SHIRT_DISCOUNT, $discount);
    }

    public function test_calculate_discount_with_shirt_quantity()
    {
        $expected = ProductService::CRAVAT_WHITE_SHIRT_DISCOUNT + ProductService::QUANTITY_DISCOUNT;
        $discount = $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => 2,
            Product::WHITE_SHIRT_TYPE => 2,
            Product::OTHER_TYPE => 10,
        ]);

        $this->assertEquals($expected, $discount);
    }

    public function test_calculate_empty_input()
    {
        $discount = $this->productService->calculateDiscount([]);
        $this->assertEquals(0, $discount);
    }
}
