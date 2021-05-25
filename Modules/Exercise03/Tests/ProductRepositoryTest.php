<?php

namespace Modules\Exercise03\Tests;

use Tests\TestCase;
use Tests\SetupDatabaseTrait;
use Illuminate\Support\Collection;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;

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

    public function testAll()
    {
        $product = new Product();

        $this->assertEqualsCanonicalizing($product->all(), $this->repository->all());
        $this->assertInstanceOf(Collection::class, $this->repository->all());
    }
}
