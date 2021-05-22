<?php

namespace Modules\Exercise03\Tests\Unit\Repositories;

use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class ProductRepositoryTest extends TestCase
{
    protected $repository;
    protected $productModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productModel = new Product();
        $this->repository = new ProductRepository($this->productModel);
    }

    public function test_all()
    {
        $response = $this->repository->all();

        $this->assertInstanceOf(Collection::class, $response);
    }
}
