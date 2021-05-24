<?php

namespace Modules\Exercise03\Tests\Feature\Models;


use Modules\Exercise03\Models\Product;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    public function test_product_new_factory()
    {
        $product = Product::factory()->make();

        $this->assertInstanceOf(Product::class, $product);
    }
}
