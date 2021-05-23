<?php

namespace Modules\Tests\Exercise03\Tests\Feature\Services;

use InvalidArgumentException;
use Illuminate\Support\Collection;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    private $productService;
    private $mockProductRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockProductRepository = $this->mock(ProductRepository::class);
        $this->productService = new ProductService($this->mockProductRepository);
    }

    /**
     * @dataProvider provideData
     */

    public function testCalculateDiscount($totalProducts, $expectValue, $testCase = 'OK')
    {
        if ($testCase === 'NG') {
            $this->expectException(InvalidArgumentException::class);
        }

        $response = $this->productService->calculateDiscount($totalProducts);
        $this->assertEquals($response, $expectValue);
    }

    public function provideData()
    {
        return [
            [
                [
                    1 => 0,
                    2 => 0,
                    3 => 0
                ],
                0
            ],
            [
                [
                    1 => 1,
                    2 => 2,
                    3 => 2
                ],
                5
            ],
            [
                [
                    1 => 1,
                    2 => 0,
                    3 => 7
                ],
                7
            ],
            [
                [
                    1 => 1,
                    2 => 2,
                    3 => 5
                ],
                12
            ],
            [
                [
                    1 => -1,
                    2 => 2,
                    3 => 9
                ],
                0,
                'NG'
            ],
            [
                [
                    1 => 1,
                    2 => -2,
                    3 => 2
                ],
                0,
                'NG'
            ],
        ];
    }

    public function testGetAllProducts()
    {
        $this->mockProductRepository
            ->shouldReceive('all')
            ->andReturn([]);

        $this->assertEquals($this->productService->getAllProducts(), []);
    }

}
