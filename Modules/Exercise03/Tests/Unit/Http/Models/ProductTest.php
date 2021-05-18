<?php

namespace Modules\Exercise03\Tests\Unit\Http\Models;

use Modules\Exercise03\Database\Factories\ProductFactory;
use Modules\Exercise03\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    function test_new_factory()
    {
        $product = Product::newFactory();

        $this->assertInstanceOf(ProductFactory::class, $product);
    }
}
