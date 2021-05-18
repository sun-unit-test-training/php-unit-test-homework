<?php

namespace Modules\Exercise03\Tests\Unit\Repositories;

use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    protected $productRepository;
    private $productModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productModel = $this->mock(Product::class);
        $this->productRepository = new ProductRepository($this->productModel);
    }

    public function test_all()
    {
        $dataAll = ['abc' => 'def'];
        $this->productModel->shouldReceive('all')->andReturn($dataAll);

        $this->assertEquals($dataAll, $this->productRepository->all());
    }
}
