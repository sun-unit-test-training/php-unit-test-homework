<?php

namespace Modules\Exercise03\Tests\Unit\Services;

use Carbon\Carbon;
use Tests\TestCase;
use InvalidArgumentException;
use Tests\SetupDatabaseTrait;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $model;
    protected $service;
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new Product;
        $this->repository = new ProductRepository($this->model);
        $this->service = new ProductService($this->repository);
    }


    function test_it_throw_exception_when_product_data_invalid()
    {
        foreach ($this->getDataTotalProductInvalid() as $totalProducts) {
            $this->expectException(InvalidArgumentException::class);
            $this->service->calculateDiscount($totalProducts);
        }
    }

    private function getDataTotalProductInvalid()
    {
        return [
            'invalid_cravat' => [Product::CRAVAT_TYPE => -1],
            'invalid_white_shirt' => [Product::WHITE_SHIRT_TYPE => -1],
            'invalid_other' => [Product::OTHER_TYPE => -1],
        ];
    }

    function test_it_return_cravat_white_shirt_discount()
    {
        $expectedDiscount = $this->service::CRAVAT_WHITE_SHIRT_DISCOUNT;
        $totalProducts = [Product::CRAVAT_TYPE => 1, Product::WHITE_SHIRT_TYPE => 1];

        $discount = $this->service->calculateDiscount($totalProducts);

        $this->assertEquals($expectedDiscount, $discount);
    }

    function test_it_return_quantity_discount()
    {
        $expectedDiscount = $this->service::CRAVAT_WHITE_SHIRT_DISCOUNT + $this->service::QUANTITY_DISCOUNT;
        $totalProducts = [
            Product::CRAVAT_TYPE => 1,
            Product::WHITE_SHIRT_TYPE => 1,
            Product::OTHER_TYPE => $this->service::TOTAL_PRODUCT_TO_DISCOUNT,
        ];

        $discount = $this->service->calculateDiscount($totalProducts);

        $this->assertEquals($expectedDiscount, $discount);
    }

    function test_get_all_products_success()
    {
        $expectedProducts = collect([]);
        $this->mock(ProductRepository::class)
            ->shouldReceive('all')
            ->andReturn($expectedProducts);

        $products = $this->service->getAllProducts();

        $this->assertInstanceOf(Collection::class, $products);
        $this->assertEquals(collect([]), $expectedProducts);
    }
}
