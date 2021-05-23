<?php

namespace Modules\Exercise03\Tests\Unit\Repositories;

use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use SetupDatabaseTrait;

    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new ProductRepository(new Product);
    }

    public function test_all()
    {
        $products = Product::factory()->count(5)->create(
            ['type' => Product::CRAVAT_TYPE]
        );

        $result = $this->repository->all();
        $this->assertCount(Product::all()->count(), $result);

    }
}
