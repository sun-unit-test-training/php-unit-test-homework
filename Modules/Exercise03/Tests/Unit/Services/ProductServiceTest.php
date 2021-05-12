<?php

namespace Modules\Exercise03\Tests\Unit\Services;

use Tests\TestCase;
use InvalidArgumentException;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Repositories\ProductRepository;

/**
 * Class ProductServiceTest
 * @package Modules\Exercise03\Tests\Unit\Services
 */
class ProductServiceTest extends TestCase
{
    /**
     * @var ProductService
     */
    protected $productService;

    /**
     * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface|ProductRepository
     */
    protected $productRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepository = \Mockery::mock(ProductRepository::class);
        $this->productService = new ProductService(
            $this->productRepository
        );
    }

    public function test_it_throws_exception_when_number_product_negative()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount([
            Product::CRAVAT_TYPE => -1,
            Product::WHITE_SHIRT_TYPE => 0,
            Product::OTHER_TYPE => 0,
        ]);
    }

    /**
     * @param $passedParams
     * @param $expectedDiscount
     * @dataProvider providerTestCalculateExercise1
     * @dataProvider providerTestCalculateExercise2
     */
    public function test_it_calculates_discount($passedParams, $expectedDiscount)
    {
        $result = $this->productService->calculateDiscount($passedParams);

        $this->assertEquals($result, $expectedDiscount);
    }

    public function test_it_gets_all_products_returns_collection()
    {
        $expected = collect(['foo' => 'bar']);
        $this->productRepository->shouldReceive('all')->andReturn($expected);

        $this->assertEquals($expected, $this->productService->getAllProducts());
    }

    /**
     * Data provider for exercise 1
     * @return array
     */
    public function providerTestCalculateExercise1()
    {
        return [
            /**
             * TC1
             * total >= 7
             * have cravat
             * have white shirt
             */
            [
                [
                    Product::CRAVAT_TYPE => 6,
                    Product::WHITE_SHIRT_TYPE => 1,
                ],
                12,
            ],
            /**
             * TC2
             * total >= 7
             * have only white shirt
             */
            [
                [
                    Product::WHITE_SHIRT_TYPE => 7,
                ],
                7,
            ],
            /**
             * TC3
             * total >= 7
             * have only cravat
             */
            [
                [
                    Product::CRAVAT_TYPE => 8,
                ],
                7,
            ],
            /**
             * TC4
             * total < 7
             * have both white shirt and cravat
             */
            [
                [
                    Product::CRAVAT_TYPE => 3,
                    Product::WHITE_SHIRT_TYPE => 3,
                ],
                5,
            ],
            /**
             * TC5
             * total < 7
             * have only white shirt
             */
            [
                [
                    Product::WHITE_SHIRT_TYPE => 3,
                ],
                0,
            ],
            /**
             * TC6
             * total < 7
             * have no cravat or white shirt
             */
            [
                [
                    Product::OTHER_TYPE => 6,
                ],
                0,
            ],
        ];
    }


    /**
     * Data provider for exercise 2
     *
     * @return array
     */
    public function providerTestCalculateExercise2()
    {
        return [
            /**
             * TC1
             * total >= 7
             * have cravat
             * have white shirt
             */
            [
                [
                    Product::CRAVAT_TYPE => 6,
                    Product::WHITE_SHIRT_TYPE => 1,
                ],
                12,
            ],
            /**
             * TC2
             * total >= 7
             * have only white shirt
             */
            [
                [
                    Product::WHITE_SHIRT_TYPE => 8,
                ],
                7,
            ],
            /**
             * TC3
             * total >= 7
             * have only cravat
             */
            [
                [
                    Product::CRAVAT_TYPE => 10,
                ],
                7,
            ],
            /**
             * TC4
             * total >= 7
             * have no cravat and white shirt
             */
            [
                [
                    Product::OTHER_TYPE => 8,
                ],
                7,
            ],
            /**
             * TC5
             * total < 7
             * have both white shirt and cravat
             */
            [
                [
                    Product::CRAVAT_TYPE => 1,
                    Product::WHITE_SHIRT_TYPE => 1,
                ],
                5,
            ],
            /**
             * TC6
             * total < 7
             * have only white shirt
             */
            [
                [
                    Product::WHITE_SHIRT_TYPE => 1,
                ],
                0,
            ],
            /**
             * TC7
             * total < 7
             * have only cravat
             */
            [
                [
                    Product::CRAVAT_TYPE => 6,
                ],
                0,
            ],
            /**
             * TC8
             * total <= 7
             * have no cravat or white shirt
             */
            [
                [
                    Product::OTHER_TYPE => 1,
                ],
                0,
            ],
        ];
    }
}
