<?php

namespace Modules\Exercise03\Tests;

use Carbon\Carbon;
use InvalidArgumentException;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $productService;
    protected $cravat;
    protected $whiteShirt;
    protected $other;

    public function setUp(): void
    {
        parent::setUp();
        $productRepository = new ProductRepository(new Product());

        $this->productService = new ProductService($productRepository);
        $product = Product::newFactory();
        $this->cravat = $product->cravat()->create();
        $this->whiteShirt = $product->whiteShirt()->create();
        $this->other = $product->other()->create();
    }

    public function testItThrowException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => -1,
            Product::WHITE_SHIRT_TYPE => -1,
            Product::OTHER_TYPE => -1,
        ]);
    }

    public function testItCalculateDiscountCompareCravatAndWhiteShirtCompare()
    {
        $discount = $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => 1,
            Product::WHITE_SHIRT_TYPE => 1,
            Product::OTHER_TYPE => 1,
        ]);

        $this->assertEquals($this->productService::CRAVAT_WHITE_SHIRT_DISCOUNT, $discount);
    }

    public function testItCalculateDiscountCompareTotalProductToDiscount()
    {
        $discount = $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => 3,
            Product::WHITE_SHIRT_TYPE => 3,
            Product::OTHER_TYPE => 3,
        ]);

        $this->assertEquals(12, $discount);
    }

    public function testGetAllProducts()
    {
        $products = $this->productService->getAllProducts();

        $this->assertEquals(3, $products->count());
        $this->assertEquals($products[0]['name'], $this->cravat->name);
        $this->assertEquals($products[1]['name'], $this->whiteShirt->name);
        $this->assertEquals($products[2]['name'], $this->other->name);
    }
}