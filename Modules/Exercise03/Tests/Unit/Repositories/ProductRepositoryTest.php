<?php

namespace Modules\Exercise03\Tests\Unit\Repositories;

use Tests\TestCase;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Tests\SetupDatabaseTrait;

class ProductRepositoryTest extends TestCase
{
    use SetupDatabaseTrait;

    /**
     * @var ProductRepository
     */
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new ProductRepository(new Product());
    }

    public function test_all()
    {
        $collection = $this->repository->all();

        $products = $collection->all();

        $this->assertEquals(count($products), 3);
    }
}
