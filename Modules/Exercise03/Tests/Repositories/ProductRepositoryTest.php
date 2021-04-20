<?php
namespace Modules\Exercise03\Tests\Repositories;

use Mockery;
use Tests\TestCase;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PriceRepositoryTest extends TestCase
{
    public function testConstruct()
    {  
        $product = new Product;
        $repository = new ProductRepository($product);

        $this->assertInstanceOf(ProductRepository::class, $repository);
    }

    public function testAll()
    {
        $product = new Product;
        $repository = new ProductRepository($product);
        $this->assertInstanceOf(Collection::class, $repository->all());
    }
}
