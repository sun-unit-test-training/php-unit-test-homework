<?php

namespace Tests\Unit\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    protected $productRepository;
    protected $productModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productModel = new Product();
        $this->productRepository = new ProductRepository($this->productModel);
    }

    public function test_all()
    {
        $this->assertInstanceOf(Collection::class, $this->productRepository->all());
    }
}
