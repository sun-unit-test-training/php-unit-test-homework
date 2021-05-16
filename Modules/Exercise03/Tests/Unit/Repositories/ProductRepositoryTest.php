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
     * @var ATMRepository
     */
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new ProductRepository(new Product());
    }

    public function test_it_get_all_correct()
    {
        $cravat = Product::factory()->cravat()->create()->fresh();
        $whiteShirt = Product::factory()->whiteShirt()->create()->fresh();
        $other = Product::factory()->other()->create()->fresh();

        $collection = $this->repository->all();

        $products = $collection->all();

        $this->assertEquals($products[0]->name, $cravat->name);
        $this->assertEquals($products[1]->name, $whiteShirt->name);
        $this->assertEquals($products[2]->name, $other->name);
    }
}
