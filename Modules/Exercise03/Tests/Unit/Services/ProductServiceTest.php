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

    protected $calendarServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = new Product();
        $repositoy = new ProductRepository($this->product);
        $this->service = new ProductService($repositoy);
    }

    /**
     * @dataProvider provider_test_alculate_discount
     */
    public function test_calculate_discount($totalProducts, $discount)
    {
        $result = $this->service->calculateDiscount($totalProducts);
    
        $this->assertEquals($result, $discount);
    }

    public function provider_test_alculate_discount()
    {
        return [
            [
                [
                    1 => 2,
                    2 => 1,
                    3 => 1,
                ], 5
            ],
            [
                [
                    1 => 2,
                    2 => 2,
                    3 => 3,
                ], 12
            ],
            [
                [
                    1 => 2,
                    2 => 5,
                    3 => 5,
                ], 12
            ],
            [
                [
                    1 => 0,
                    2 => 1,
                    3 => 1,
                ], 0
            ],
            [
                [
                    1 => 0,
                    2 => 5,
                    3 => 5,
                ], 7
            ],
            [
                [
                    1 => 0,
                    2 => 0,
                    3 => 5,
                ], 0
            ],
            [
                [
                    1 => 0,
                    2 => 0,
                    3 => 8,
                ], 7
            ],
            [
                [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                ], 0
            ],
        ];
    }

    /**
     * @dataProvider provider_test_function_throw_exception
     */

    public function test_function_throw_exception($totalProducts)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->calculateDiscount($totalProducts);
    }

    public function provider_test_function_throw_exception()
    {
        return [
            [
                [
                   1 => -5,
                   2 => 5,
                   3 => 5,
               ]
            ],
            [
                [
                    1 => 5,
                    2 => -5,
                    3 => 5,
                ]
                
            ],
            [
                [
                    1 => 5,
                    2 => 5,
                    3 => -5,
                ]
            ],
            [
                [
                    1 => -5,
                    2 => -5,
                    3 => -5,
                ]
            ],
        ];
    }

    public function test_get_all_products()
    {
        $this->product->create(['name' => 'product1', 'type' => 1]);
        $this->product->create(['name' => 'product2', 'type' => 2]);
        $this->product->create(['name' => 'product3', 'type' => 3]);

        $products = $this->service->getAllProducts();

        $this->assertEquals($products->count(), 6);
    }
}
