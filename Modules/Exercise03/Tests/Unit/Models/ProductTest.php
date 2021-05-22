<?php

namespace Tests\Unit\Models;

use Modules\Exercise03\Models\Product;
use Tests\TestCase;
use Modules\Exercise03\Database\Factories\ProductFactory;

class ProductTest extends TestCase
{
    function test_new_factory()
    {
        $product = Product::newFactory();

        $this->assertInstanceOf(ProductFactory::class, $product);
    }
}