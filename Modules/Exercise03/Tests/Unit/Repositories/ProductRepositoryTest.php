<?php

namespace Modules\Exercise03\Tests\Unit\Repositories;

use Tests\TestCase;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Tests\SetupDatabaseTrait;
use Illuminate\Database\Eloquent\Collection;

class ProductRepositoryTest extends TestCase
{
    use SetupDatabaseTrait;

    /**
     * @var ATMRepository
     */
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new ProductRepository(new Product());
    }

    public function testGetAllProduct()
    {
        $cravat = Product::factory()->cravat()->create()->fresh();
        $whiteShirt = Product::factory()->whiteShirt()->create()->fresh();
        $other = Product::factory()->other()->create()->fresh();

        $collection = $this->repository->all();

        $this->assertInstanceOf(Collection::class, $collection);
    }
}
