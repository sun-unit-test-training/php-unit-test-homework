<?php

namespace Modules\Exercise03\Tests\Unit\Services;

use InvalidArgumentException;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $productRepository = new ProductRepository(new Product());
        $this->service = new ProductService($productRepository);
    }

    public function testGetAllProducts()
    {

        $productRepository = $this->mock(ProductRepository::class);
        $productRepository
            ->shouldReceive('all')
            ->andReturn([]);
        $products = $this->service->getAllProducts();

        $this->assertEquals($products->all(), []);
    }

    /**
     * @dataProvider provideValidTotalProducts
     */
    public function testCalculateDiscountSuccess($discount, $totalProducts)
    {
        $result = $this->service->calculateDiscount($totalProducts);

        $this->assertEquals($result, $discount);
    }

    function provideValidTotalProducts()
    {
        return [
            [5, [1 => 2, 2 => 2, 3 => 2]],
            [12, [1 => 1, 2 => 2, 3 => 4]],
            [7, [1 => 1, 2 => 0, 3 => 6]],
            [0, [1 => 1, 2 => 0, 3 => 3]],
        ];
    }

    /**
     * @dataProvider provideInValidTotalProducts
     */
    public function testCalculateDiscountInvalid($totalProducts)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->calculateDiscount($totalProducts);
    }

    function provideInValidTotalProducts()
    {
        return [
            [[1 => -1, 2 => 0, 3 => 0]],
            [[1 => 0, 2 => -1, 3 => 0]],
            [[1 => 0, 2 => 0, 3 => -1]]
        ];
    }
}
