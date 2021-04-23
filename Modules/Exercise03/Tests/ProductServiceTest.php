<?php

namespace Tests\Feature;

use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;
use Mockery;
use InvalidArgumentException;

class ProductServiceTest extends TestCase
{
    protected $service;
    protected $cravat;
    protected $whiteShirt;
    protected $other;

    public function setUp(): void
    {
        parent::setUp();
        $model = new Product();
        $repository = new ProductRepository($model);
        $this->service = new ProductService($repository);

        $product = Product::newFactory();
        $this->cravat = $product->cravat()->create();
        $this->whiteShirt = $product->whiteShirt()->create();
        $this->other = $product->other()->create();
    }

    public function test__construct()
    {
        $repository = Mockery::mock(ProductRepository::class);
        $service = new ProductService($repository);
        $repositoryRef = $this->getHiddenProperty($service, 'productRepository');
        $this->assertSame($repository, $repositoryRef->getValue($service));
    }

    public function test_get_all_products()
    {
        $products = $this->service->getAllProducts();

        $this->assertEquals(3, $products->count());
        $this->assertEquals($products[0]['name'], $this->cravat->name);
        $this->assertEquals($products[1]['name'], $this->whiteShirt->name);
        $this->assertEquals($products[2]['name'], $this->other->name);
    }

    /**
     * @param $totalProducts
     * @param $expected
     * @dataProvider total_product_input_for_discount
     * */
    public function test_discount($totalProducts, $expected)
    {
        $discount = $this->service->calculateDiscount($totalProducts);
        $this->assertEquals($expected, $discount);
    }

    public function total_product_input_for_discount()
    {
        return [
            [
                [
                    1 => 1,
                    2 => 2,
                    3 => 4,
                ], 12
            ],
            [
                [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                ], 5
            ],
            [
                [
                    1 => 6,
                    2 => 2,
                    3 => 3,
                ], 12
            ],
        ];
    }

    /**
     * @param $totalProducts
     * @dataProvider total_product_input_for_discount_exception
     * */
    public function test_discount_with_exception($totalProducts)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->calculateDiscount($totalProducts);
    }

    public function total_product_input_for_discount_exception()
    {
        return [
            [
                [
                    1 => -1,
                    2 => 2,
                    3 => 4,
                ]
            ],
            [
                [
                    1 => 1,
                    2 => -2,
                    3 => 4,
                ]
            ],
            [
                [
                    1 => 1,
                    2 => 2,
                    3 => -4,
                ]
            ],
            [
                [
                    1 => -1,
                    2 => -2,
                    3 => -4,
                ]
            ]
        ];
    }
}
