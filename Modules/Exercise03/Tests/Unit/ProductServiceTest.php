<?php

namespace Modules\Exercise03\Tests\Unit;

use Tests\TestCase;
use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Repositories\ProductRepository;
use Mockery as m;
use InvalidArgumentException;

class ProductServiceTest extends TestCase
{
    protected $service;
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = m::mock(ProductRepository::class);
        $this->service = new ProductService($this->repository);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_without_any_products()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->calculateDiscount([]);
    }

    public function test_less_than_7_products_including_both_shirt_and_caravat()
    {
        $products = [
            '1' => 2,
            '2' => 3,
        ];
        $result = $this->service->calculateDiscount($products);
        $this->assertEquals(5, $result);
    }

    public function test_less_than_7_products_including_caravat_and_other()
    {
        $products = [
            '1' => 3,
            '3' => 1,
        ];
        $result = $this->service->calculateDiscount($products);
        $this->assertEquals(0, $result);
    }

    public function test_less_than_7_products_including_shirt_and_other()
    {
        $products = [
            '2' => 3,
            '3' => 1,
        ];
        $result = $this->service->calculateDiscount($products);
        $this->assertEquals(0, $result);
    }

    public function test_more_than_7_products_including_both_shirt_and_caravat()
    {
        $products = [
            '1' => 5,
            '2' => 3,
        ];
        $result = $this->service->calculateDiscount($products);
        $this->assertEquals(12, $result);
    }

    public function test_more_than_7_products()
    {
        $products = [
            '3' => 7,
        ];
        $result = $this->service->calculateDiscount($products);
        $this->assertEquals(7, $result);
    }

    public function test_more_than_7_products_including_shirt_and_other()
    {
        $products = [
            '2' => 4,
            '3' => 4,
        ];
        $result = $this->service->calculateDiscount($products);
        $this->assertEquals(7, $result);
    }

    public function test_more_than_7_products_including_caravat_and_other()
    {
        $products = [
            '1' => 4,
            '3' => 4,
        ];
        $result = $this->service->calculateDiscount($products);
        $this->assertEquals(7, $result);
    }

    public function test_get_all_products()
    {
        $this->repository->shouldReceive('all')->andReturn([]);
        $result = $this->service->getAllProducts();
        $this->assertEquals([], $result);
    }
}
