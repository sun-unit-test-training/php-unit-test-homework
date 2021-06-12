<?php

namespace Modules\Exercise03\Tests\Unit\Services;

use InvalidArgumentException;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $productService;

    public function setUp(): void
    {
        parent::setUp();
        $this->productRepository = $this->mock(ProductRepository::class);
        $this->productService = new ProductService($this->productRepository);
    }

    public function test_it_get_all_products()
    {
        $this->productRepository
            ->shouldReceive('all')
            ->andReturn([]);
        $products = $this->productService->getAllProducts();

        $this->assertEquals($products, []);
    }

    /**
     * @dataProvider provideValidTotalProducts
     */
    public function test_it_calculate_discount_when_valid_argument($discount, $totalProducts)
    {
        $result = $this->productService->calculateDiscount($totalProducts);

        $this->assertEquals($result, $discount);
    }

    function provideValidTotalProducts()
    {
        return [
            'Have Cravat White Shirt & Total Less Than 7' => [5, [1 => 1, 2 => 1, 3 => 1]],
            'Have Cravat White Shirt & Total Equal 7' => [12, [1 => 1, 2 => 1, 3 => 5]],
            'Have Both Cravat White Shirt False & Total Equal 7' => [7, [1 => 1, 2 => 0, 3 => 6]],
            'Have Both Cravat White Shirt False & Total Less Than 7' => [0, [1 => 1, 2 => 0, 3 => 3]],
            'Cravat No Exist Or Equal 0' => [0 , [1 => null, 2 => 1, 3 => 1]],
            'White Shirt No Exist Or Equal 0' => [0, [1 => 1, 2 => null, 3 => 1]],
            'Others No Exist Or Equal 0' => [5, [1 => 3, 2 => 3, 3 => null]]
        ];
    }

    /**
     * @dataProvider provideInValidTotalProducts
     */
    public function test_it_calculate_discount_when_invalid_argument($totalProducts)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount($totalProducts);
    }

    function provideInValidTotalProducts()
    {
        return [
            'Cravat Less Than 0' => [[1 => -1, 2 => 0, 3 => 0]],
            'White Shirt Less Than 0' => [[1 => 0, 2 => -1, 3 => 0]],
            'Others Less Than 0' => [[1 => 0, 2 => 0, 3 => -1]]
        ];
    }
}
