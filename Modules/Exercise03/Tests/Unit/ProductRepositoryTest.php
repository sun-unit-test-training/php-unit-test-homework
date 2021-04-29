<?php

namespace Modules\Exercise03\Tests\Unit;

use Tests\TestCase;
use Modules\Exercise03\Repositories\ProductRepository;
use Mockery as m;
use Modules\Exercise03\Models\Product;

class ProductRepositoryTest extends TestCase
{
    protected $productRepository;
    protected $model;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = $this->mock(Product::class)->makePartial();
        $this->productRepository = new ProductRepository($this->model);
    }

    public function test_find()
    {
        $this->model->shouldReceive('all')->andReturn([]);

        $result = $this->productRepository->all(1);
        $this->assertEquals([], $result);
    }
}
