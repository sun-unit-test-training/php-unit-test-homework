<?php

namespace Tests\Feature;

use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class ProductRepositoryTest extends TestCase
{
    public function test__construct()
    {
        $product = new Product();
        $repository = new ProductRepository($product);
        $this->assertInstanceOf(ProductRepository::class, $repository);
    }

    public function test_all()
    {
        $product = new Product();
        $repository = new ProductRepository($product);
        $this->assertEqualsCanonicalizing($product->all(), $repository->all());
        $this->assertInstanceOf(Collection::class, $repository->all());
    }
}
