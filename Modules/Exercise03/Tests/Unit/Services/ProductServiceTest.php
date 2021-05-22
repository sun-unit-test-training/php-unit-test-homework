<?php

namespace Tests\Unit\Services;

use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Models\Product;
use InvalidArgumentException;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $productService;

    protected $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = new Product();
        $repository = new ProductRepository($this->product);
        $this->productService = new ProductService($repository);
    }

    public function test_throw_exception_when_product_type_does_not_exist()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount([
            Product::WHITE_SHIRT_TYPE => -1111,
        ]);
    }

    public function test_case_calculate_discount_return_caravat_white_shirt()
    {
        $discount = $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => 12,
            Product::WHITE_SHIRT_TYPE => 13,
            Product::OTHER_TYPE => -14,
        ]);

        $this->assertEquals(ProductService::CRAVAT_WHITE_SHIRT_DISCOUNT, $discount);
    }

    public function test_case_calculate_discount_return_quantity_discount()
    {
        $discount = $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => 5,
            Product::WHITE_SHIRT_TYPE => 4,
            Product::OTHER_TYPE => 0,
        ]);

        $this->assertEquals(12, $discount);
    }

    public function test_get_all_products()
    {
        $product = Product::newFactory();

        $this->cravat = $product->cravat()->create();
        $this->whiteShirt = $product->whiteShirt()->create();
        $this->other = $product->other()->create();

        $products = $this->productService->getAllProducts();

        $this->assertEquals(3, $products->count());
        $this->assertEquals($products[0]['name'], $this->cravat->name);
        $this->assertEquals($products[1]['name'], $this->whiteShirt->name);
        $this->assertEquals($products[2]['name'], $this->other->name);
    }
}
