<?php
namespace App\Modules\Exercise03\Tests\Services;

use Mockery;
use Tests\TestCase;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class PriceServiceTest extends TestCase
{
    public function testConstruct()
    {
        $product = new Product;
        $productRepository = new ProductRepository($product);
        $service = new ProductService($productRepository);

        $this->assertInstanceOf(ProductService::class, $service);
    }

    /**
     * @dataProvider providerTestCalculateDiscount
     */
    public function testCalculateDiscount($input, $expect)
    {
        $product = new Product;
        $repository = new ProductRepository($product);
        $service = new ProductService($repository);
        $response = $service->calculateDiscount($input);

        $this->assertEquals($expect, $response);
    }

    public function testCalculateDiscountResponseIsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $input = [
            1 => -1,
            2 => 1,
            3 => 2,
        ];
        $product = new Product;
        $repository = new ProductRepository($product);
        $service = new ProductService($repository);
        $service->calculateDiscount($input);
    }

    public function testGetAllProducts()
    {
        $product = new Product;
        $repository = new ProductRepository($product);
        $service = new ProductService($repository);

        $this->assertInstanceOf(Collection::class, $service->getAllProducts());
    }

    public function providerTestCalculateDiscount()
    {
        return [
            $this->exampleData(1, 3, 2, ProductService::CRAVAT_WHITE_SHIRT_DISCOUNT),
            $this->exampleData(5, 5, 5, ProductService::QUANTITY_DISCOUNT + ProductService::CRAVAT_WHITE_SHIRT_DISCOUNT),
        ];
    }

    public function exampleData($cravat, $whiteShirt, $others, $expert)
    {
        return [
            [
                1 => $cravat,
                2 => $whiteShirt,
                3 => $others,
            ],
           $expert,
        ];
    }
}
