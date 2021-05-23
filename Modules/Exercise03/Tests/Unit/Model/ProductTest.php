<?php

namespace Modules\Exercise03\Tests\Unit\Model;

use Modules\Exercise03\Database\Factories\ProductFactory;
use Modules\Exercise03\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_new_factory()
    {
        $factory = Product::newFactory();

        $this->assertInstanceOf(ProductFactory::class, $factory);
    }
}
