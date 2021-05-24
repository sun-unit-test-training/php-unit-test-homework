<?php

namespace Modules\Exercise03\Tests\Feature\Http\Repositories;

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

    public function test_all()
    {
        $repository = new ProductRepository(new Product());
        $getAll = $repository->all();
        $this->assertInstanceOf(Collection::class, $getAll);
    }
}
