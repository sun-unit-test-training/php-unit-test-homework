<?php

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Repositories\ProductRepository;

class Exercise03ServiceTest extends TestCase
{
    public $productService;

    public function setUp(): void
    {
        parent::setUp();

        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->productService = new ProductService($this->productRepository);
    }

    public function test_total_product_is_negative_integers()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectException($this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => -1
        ]));
    }

    public function test_cravat_white_shirt_greater_than_seven()
    {
        $result = $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => 5,
            Product::WHITE_SHIRT_TYPE => 5,
        ]);

        $this->assertEquals(12, $result);
    }

    public function test_cravat_white_shirt_less_than_seven()
    {
        $result = $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => 1,
            Product::WHITE_SHIRT_TYPE => 1,
        ]);

        $this->assertEquals(5, $result);
    }

    public function test_full_item_less_than_seven()
    {
        $result = $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => 1,
            Product::WHITE_SHIRT_TYPE => 1,
            Product::OTHER_TYPE => 1,
        ]);

        $this->assertEquals(5, $result);
    }

    public function test_full_item_greater_than_or_equal_to_seven()
    {
        $result = $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => 1,
            Product::WHITE_SHIRT_TYPE => 1,
            Product::OTHER_TYPE => 5,
        ]);

        $this->assertEquals(12, $result);
    }
}
