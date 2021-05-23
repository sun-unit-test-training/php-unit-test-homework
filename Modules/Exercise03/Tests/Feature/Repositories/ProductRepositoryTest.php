<?php

namespace Modules\Tests\Exercise03\Tests\Feature\Repositories;

use Illuminate\Support\Collection;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testAll()
    {
        $repository = new ProductRepository(new Product());
        $getAll = $repository->all();
        $this->assertInstanceOf(Collection::class, $getAll);
    }
}
